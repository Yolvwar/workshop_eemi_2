@extends('layouts.shop')

@section('title', 'Catalogue - Boutique APWAP')
@section('page-title', 'Catalogue Premium')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header avec filtres -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900">Catalogue Premium</h1>
                    <p class="text-gray-600 mt-1">{{ $products->total() }} produits disponibles</p>
                </div>
                
                <!-- Actions rapides -->
                <div class="flex flex-wrap gap-3">
                    <button onclick="toggleFilters()" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-medium hover:bg-emerald-200 transition-colors flex items-center gap-2">
                        <x-heroicon-o-adjustments-horizontal class="w-4 h-4" />
                        Filtres
                    </button>
                    <a href="{{ route('shop.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        ← Retour boutique
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filtres -->
            <div id="filters-sidebar" class="hidden lg:block">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-36 z-40">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Filtres</h3>
                    
                    <form action="{{ route('shop.catalog') }}" method="GET" id="filters-form">
                        <!-- Recherche -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Nom du produit..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Catégories -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Espèces -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Espèce</label>
                            <div class="space-y-2">
                                @foreach(['dog' => 'Chien', 'cat' => 'Chat', 'bird' => 'Oiseau', 'fish' => 'Poisson'] as $value => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" name="species[]" value="{{ $value }}" 
                                           {{ in_array($value, request('species', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Prix -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (AED)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" min="0"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" min="0"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>

                        <!-- Piliers APWAP -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilier de santé</label>
                            <select name="pillar" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Tous les piliers</option>
                                <option value="sante" {{ request('pillar') === 'sante' ? 'selected' : '' }}>🏥 Santé</option>
                                <option value="nutrition" {{ request('pillar') === 'nutrition' ? 'selected' : '' }}>🍽️ Nutrition</option>
                                <option value="activite" {{ request('pillar') === 'activite' ? 'selected' : '' }}>🏃 Activité</option>
                                <option value="mental" {{ request('pillar') === 'mental' ? 'selected' : '' }}>🧠 Mental</option>
                                <option value="environnement" {{ request('pillar') === 'environnement' ? 'selected' : '' }}>🌡️ Environnement</option>
                                <option value="social" {{ request('pillar') === 'social' ? 'selected' : '' }}>👥 Social</option>
                            </select>
                        </div>

                        <!-- Notation -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Note minimum</label>
                            <select name="min_rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Toutes les notes</option>
                                <option value="4" {{ request('min_rating') === '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4+ étoiles</option>
                                <option value="3" {{ request('min_rating') === '3' ? 'selected' : '' }}>⭐⭐⭐ 3+ étoiles</option>
                                <option value="2" {{ request('min_rating') === '2' ? 'selected' : '' }}>⭐⭐ 2+ étoiles</option>
                            </select>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 bg-emerald-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                Appliquer
                            </button>
                            <a href="{{ route('shop.catalog') }}" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-3">
                <!-- Barre de tri et vue -->
                <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                            <span class="text-sm text-gray-600">Trier par:</span>
                            <select name="sort" onchange="updateSort(this)" class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Popularité</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Mieux notés</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Vue:</span>
                            <button onclick="toggleView('grid')" id="grid-view" class="p-2 text-gray-600 hover:text-emerald-600 view-toggle active">
                                <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                            </button>
                            <button onclick="toggleView('list')" id="list-view" class="p-2 text-gray-600 hover:text-emerald-600 view-toggle">
                                <x-heroicon-o-list-bullet class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Liste des produits -->
                @if($products->count() > 0)
                <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="product-card bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 group flex flex-col h-full">
                        <div class="relative flex-shrink-0">
                            @if($product->images && count($product->images) > 0)
                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <x-heroicon-o-cube class="w-12 h-12 text-gray-400" />
                            </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if($product->original_price && $product->original_price > $product->price)
                                <div class="bg-red-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow-lg">
                                    -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                </div>
                                @endif
                                @if($product->featured)
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-2 rounded-full shadow-lg">
                                    <x-heroicon-s-star class="w-3 h-3" />
                                </div>
                                @endif
                            </div>

                            <!-- Actions hover -->
                            <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('shop.product', $product->slug) }}" class="bg-white/90 backdrop-blur-sm text-gray-800 p-2 rounded-full hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg">
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                </a>
                                <button onclick="addToWishlist('{{ $product->id }}')" class="bg-white/90 backdrop-blur-sm text-gray-800 p-2 rounded-full hover:bg-white hover:scale-110 transition-all duration-200 shadow-lg hover:text-red-500">
                                    <x-heroicon-o-heart class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        
                        <div class="p-5 flex flex-col flex-grow">
                            <!-- Category and Pillars -->
                            <div class="mb-3 flex flex-wrap gap-1">
                                <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">
                                    {{ $product->category->name }}
                                </span>
                                @if($product->primary_pillar)
                                <span class="text-xs text-blue-700 font-semibold bg-blue-50 px-3 py-1.5 rounded-full border border-blue-200">
                                    {{ ucfirst($product->primary_pillar) }}
                                </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 mb-2 text-base group-hover:text-emerald-600 transition-colors leading-tight line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Description -->
                            @if($product->short_description)
                            <p class="text-sm text-gray-600 mb-4 leading-relaxed line-clamp-2">{{ $product->short_description }}</p>
                            @endif
                            
                            <!-- Rating -->
                            @if($product->rating > 0)
                            <div class="flex items-center mb-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                        <x-heroicon-s-star class="w-4 h-4 text-yellow-400" />
                                        @else
                                        <x-heroicon-o-star class="w-4 h-4 text-gray-300" />
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 ml-2">({{ $product->rating }})</span>
                                @if($product->review_count)
                                <span class="text-xs text-gray-500 ml-1">{{ $product->review_count }} avis</span>
                                @endif
                            </div>
                            @endif
                            
                            <!-- Stock indicator -->
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                            <div class="mb-4">
                                @if($product->stock_quantity > 0)
                                <span class="text-xs text-orange-700 bg-orange-50 px-3 py-1.5 rounded-full border border-orange-200 font-semibold flex items-center gap-1">
                                    <x-heroicon-o-exclamation-triangle class="w-3 h-3" />
                                    Stock limité ({{ $product->stock_quantity }})
                                </span>
                                @else
                                <span class="text-xs text-red-700 bg-red-50 px-3 py-1.5 rounded-full border border-red-200 font-semibold flex items-center gap-1">
                                    <x-heroicon-o-x-circle class="w-3 h-3" />
                                    Rupture de stock
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            <!-- Spacer pour pousser le prix et les boutons vers le bas -->
                            <div class="flex-grow"></div>
                            
                            <!-- Price Section -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl font-bold text-gray-900">{{ $product->price }} AED</span>
                                        @if($product->original_price && $product->original_price > $product->price)
                                        <span class="text-sm text-gray-500 line-through">{{ $product->original_price }} AED</span>
                                        @endif
                                    </div>
                                    @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-sm font-semibold text-green-600">
                                        Économie {{ $product->original_price - $product->price }} AED
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Buttons (Always at bottom) -->
                            <div class="flex flex-col gap-2 mt-auto">
                                @if($product->stock_quantity > 0)
                                <!-- Add to Cart Button -->
                                <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-3 px-4 rounded-lg text-sm font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                        <x-heroicon-o-shopping-cart class="w-4 h-4" />
                                        Ajouter au panier
                                    </button>
                                </form>
                                
                                <!-- View Details Button -->
                                <a href="{{ route('shop.product', $product->slug) }}" class="w-full bg-white text-gray-700 py-2.5 px-4 rounded-lg text-center text-sm font-medium hover:bg-gray-50 transition-colors border border-gray-300 hover:border-gray-400">
                                    Voir les détails
                                </a>
                                @else
                                <!-- Out of Stock Button -->
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-4 rounded-lg text-sm font-medium cursor-not-allowed mb-2">
                                    Indisponible
                                </button>
                                
                                <!-- View Details Button (still available) -->
                                <a href="{{ route('shop.product', $product->slug) }}" class="w-full bg-white text-gray-700 py-2.5 px-4 rounded-lg text-center text-sm font-medium hover:bg-gray-50 transition-colors border border-gray-300 hover:border-gray-400">
                                    Voir les détails
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @else
                <!-- État vide -->
                <div class="text-center py-12">
                    <div class="max-w-md mx-auto">
                        <x-heroicon-o-magnifying-glass class="w-24 h-24 text-gray-300 mx-auto mb-4" />
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
                        <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche ou explorez nos catégories populaires.</p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('shop.catalog') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                Voir tous les produits
                            </a>
                            <a href="{{ route('shop.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFilters() {
        const sidebar = document.getElementById('filters-sidebar');
        sidebar.classList.toggle('hidden');
    }

    function updateSort(select) {
        const url = new URL(window.location);
        url.searchParams.set('sort', select.value);
        window.location.href = url.toString();
    }

    function toggleView(viewType) {
        const container = document.getElementById('products-container');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        
        document.querySelectorAll('.view-toggle').forEach(btn => btn.classList.remove('active'));
        
        if (viewType === 'grid') {
            container.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6';
            gridView.classList.add('active');
        } else {
            container.className = 'space-y-6';
            listView.classList.add('active');
            
            document.querySelectorAll('.product-card').forEach(card => {
                card.className = 'product-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col sm:flex-row';
            });
        }
    }

    function addToWishlist(productId) {
        // Implémentation de la wishlist ( à faire)
        console.log('Ajouter à la wishlist:', productId);

    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filters-form');
        const inputs = form.querySelectorAll('select, input[type="checkbox"]');
        
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                form.submit();
            });
        });
    });
</script>

<style>
    .view-toggle.active {
        @apply text-emerald-600 bg-emerald-50;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 1024px) {
        #filters-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            padding: 2rem;
        }
        
        #filters-sidebar > div {
            max-height: 90vh;
            overflow-y: auto;
        }
    }
</style>
@endpush
@endsection
