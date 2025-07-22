<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Pet;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Page d'accueil de la boutique
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $pets = $user ? $user->pets : collect();
        
        $categories = ProductCategory::getMainWithChildren();
        
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->limit(8)
            ->get();
        
        $recommendations = [];
        if ($pets->isNotEmpty()) {
            foreach ($pets->take(3) as $pet) {
                $recommendations[$pet->id] = [
                    'pet' => $pet,
                    'products' => $pet->getRecommendedProducts(3)
                ];
            }
        }
        
        $popularProducts = Product::getPopularProducts(6);
        
        return view('shop.index', compact(
            'categories',
            'featuredProducts',
            'recommendations',
            'popularProducts',
            'pets'
        ));
    }

    /**
     * Catalogue des produits avec filtres
     */
    public function catalog(Request $request)
    {
        $query = Product::active()->inStock()->with(['category', 'reviews']);
        
        if ($request->filled('category')) {
            $query->inCategory($request->category);
        }
        
        if ($request->filled('species')) {
            $query->suitableForSpecies($request->species);
        }
        
        if ($request->filled('pillar')) {
            $query->forPillar($request->pillar);
        }
        
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $sortBy = $request->get('sort', 'popularity');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc')->orderBy('review_count', 'desc');
                break;
            default:
                $query->orderBy('review_count', 'desc')->orderBy('rating', 'desc');
        }
        
        $products = $query->paginate(12);
        
        $categories = ProductCategory::getMainWithChildren();
        $priceRange = [
            'min' => Product::active()->min('price'),
            'max' => Product::active()->max('price')
        ];
        
        $pets = auth()->user() ? auth()->user()->pets : collect();
        
        return view('shop.catalog', compact(
            'products',
            'categories',
            'priceRange',
            'pets'
        ));
    }

    /**
     * Page détail d'un produit
     */
    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user', 'reviews.pet']);
        
        $similarProducts = Product::active()
            ->inStock()
            ->inCategory($product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        
        $reviews = $product->reviews()
            ->approved()
            ->with(['user', 'pet'])
            ->latest()
            ->paginate(5);
        
        $pets = auth()->user() ? auth()->user()->pets : collect();
        
        $suitableForUserPets = collect();
        foreach ($pets as $pet) {
            if ($product->suitable_for_species && 
                in_array($pet->species, $product->suitable_for_species)) {
                $suitableForUserPets->push($pet);
            }
        }
        
        return view('shop.product', compact(
            'product',
            'similarProducts',
            'reviews',
            'pets',
            'suitableForUserPets'
        ));
    }

    /**
     * Recherche Ajax pour autocomplete et page de recherche
     */
    public function search(Request $request)
    {
        $term = $request->get('q');
        
        if ($request->ajax() || $request->expectsJson()) {
            if (strlen($term) < 2) {
                return response()->json([]);
            }
            
            $products = Product::active()
                ->search($term)
                ->limit(10)
                ->get(['id', 'name', 'price', 'images'])
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'price_formatted' => number_format($product->price, 0) . ' AED',
                        'image' => $product->main_image,
                        'url' => route('shop.product', $product)
                    ];
                });
            
            return response()->json($products);
        }
        
        $query = Product::active()->inStock()->with(['category', 'reviews']);
        $categories = ProductCategory::whereNull('parent_id')->with('children')->get();
        
        if ($term && strlen($term) >= 2) {
            $query->search($term);
        }
        
        if ($request->filled('category')) {
            $category = ProductCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        if ($request->filled('animal_type')) {
            $animalType = $request->animal_type;
            $query->whereJsonContains('suitable_for_species', $animalType);
        }
        
        if ($request->filled('price_range')) {
            $range = $request->price_range;
            switch ($range) {
                case '0-20':
                    $query->where('price', '<=', 20);
                    break;
                case '20-50':
                    $query->whereBetween('price', [20, 50]);
                    break;
                case '50-100':
                    $query->whereBetween('price', [50, 100]);
                    break;
                case '100-200':
                    $query->whereBetween('price', [100, 200]);
                    break;
                case '200+':
                    $query->where('price', '>', 200);
                    break;
            }
        }
        
        switch ($request->get('sort', 'relevance')) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                if ($term) {
                } else {
                    $query->orderBy('review_count', 'desc');
                }
        }
        
        $products = $query->paginate(12);
        
        $popularSearches = collect(['croquettes', 'jouets', 'laisse', 'litière', 'aquarium', 'cage']);
        
        return view('shop.search', compact('products', 'categories', 'popularSearches', 'term'))->with('query', $term);
    }

    /**
     * Recommandations pour un animal spécifique
     */
    public function petRecommendations(Pet $pet)
    {
        $this->authorize('view', $pet);
        
        $recommendations = $pet->getRecommendedProducts(12);
        
        return view('shop.pet-recommendations', compact('pet', 'recommendations'));
    }

    /**
     * Produits par catégorie
     */
    public function category(ProductCategory $category, Request $request)
    {
        $query = $category->products()
            ->active()
            ->inStock()
            ->with(['category', 'reviews']);
        
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        if ($request->filled('species')) {
            $query->suitableForSpecies($request->species);
        }
        
        $sortBy = $request->get('sort', 'popularity');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('review_count', 'desc');
        }
        
        $products = $query->paginate(12);
        
        $pets = auth()->user() ? auth()->user()->pets : collect();
        
        return view('shop.category', compact('category', 'products', 'pets'));
    }
}
