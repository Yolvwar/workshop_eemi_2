<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Pet;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        $cart->load(['items.product', 'items.pet']);
        
        $suggestions = [];
        if ($cart->items->isNotEmpty()) {
            $categories = $cart->items->pluck('product.category_id')->unique();
            $suggestions = Product::active()
                ->inStock()
                ->whereIn('category_id', $categories)
                ->whereNotIn('id', $cart->items->pluck('product_id'))
                ->limit(4)
                ->get();
        }
        
        return view('cart.index', compact('cart', 'suggestions'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10',
            'pet_id' => 'nullable|exists:pets,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if (!$product->isInStock()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce produit n\'est plus en stock.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Ce produit n\'est plus en stock.');
        }

        if ($request->pet_id) {
            $pet = Pet::where('id', $request->pet_id)
                     ->where('user_id', auth()->id())
                     ->first();
            if (!$pet) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Animal non trouvé.'
                    ], 400);
                }
                
                return redirect()->back()->with('error', 'Animal non trouvé.');
            }
        }

        $cart = auth()->user()->getOrCreateActiveCart();
        $quantity = $request->get('quantity', 1);

        try {
            $item = $cart->addItem($product, $quantity, $request->pet_id);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produit ajouté au panier !',
                    'cart_count' => $cart->items_count,
                    'cart_total' => number_format($cart->total_amount, 0) . ' AED'
                ]);
            }
            
            return redirect()->back()->with('success', 'Produit ajouté au panier !');
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'ajout au panier.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout au panier.');
        }
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:0|max:10'
        ]);

        $cart = auth()->user()->getOrCreateActiveCart();
        
        try {
            $cart->updateItemQuantity($request->item_id, $request->quantity);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quantité mise à jour.',
                    'cart_count' => $cart->items_count,
                    'cart_total' => number_format($cart->total_amount, 0) . ' AED'
                ]);
            }
            
            return redirect()->back()->with('success', 'Quantité mise à jour.');
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    /**
     * Supprimer un article du panier
     */
    public function remove(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:cart_items,id'
        ]);

        $cart = auth()->user()->getOrCreateActiveCart();
        
        try {
            $cart->removeItem($request->item_id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Article supprimé du panier.',
                    'cart_count' => $cart->items_count,
                    'cart_total' => number_format($cart->total_amount, 0) . ' AED'
                ]);
            }
            
            return redirect()->back()->with('success', 'Article supprimé du panier.');
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Vider le panier
     */
    public function clear(Request $request)
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        
        try {
            $cart->clear();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Panier vidé.'
                ]);
            }
            
            return redirect()->back()->with('success', 'Panier vidé.');
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du vidage du panier.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Erreur lors du vidage du panier.');
        }
    }

    /**
     * Obtenir le nombre d'articles dans le panier (pour le header)
     */
    public function count()
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        
        return response()->json([
            'count' => $cart->items_count,
            'total' => number_format($cart->total_amount, 0) . ' AED'
        ]);
    }

    /**
     * Mini panier pour le dropdown
     */
    public function mini()
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        $cart->load(['items.product' => function($query) {
            $query->select('id', 'name', 'price', 'images');
        }]);

        return response()->json([
            'items' => $cart->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => number_format($item->unit_price, 0) . ' AED',
                    'total_price' => number_format($item->total_price, 0) . ' AED',
                    'image' => $item->product->main_image,
                    'product_url' => route('shop.product', $item->product)
                ];
            }),
            'total' => number_format($cart->total_amount, 0) . ' AED',
            'items_count' => $cart->items_count
        ]);
    }

    /**
     * Appliquer un code promo
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $cart = auth()->user()->getOrCreateActiveCart();
        
        $validCoupons = [
            'WELCOME10' => 10, // 10% de réduction
            'SUMMER20' => 20,  // 20% de réduction
            'FIRSTORDER' => 15 // 15% de réduction
        ];

        $couponCode = strtoupper($request->coupon_code);
        
        if (!isset($validCoupons[$couponCode])) {
            return response()->json([
                'success' => false,
                'message' => 'Code promo invalide.'
            ], 400);
        }

        $cart->coupon_code = $couponCode;
        $cart->save();
        $cart->recalculate();

        return response()->json([
            'success' => true,
            'message' => 'Code promo appliqué !',
            'discount' => number_format($cart->discount_amount, 0) . ' AED',
            'total' => number_format($cart->total_amount, 0) . ' AED'
        ]);
    }

    /**
     * Supprimer le code promo
     */
    public function removeCoupon()
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        $cart->coupon_code = null;
        $cart->save();
        $cart->recalculate();

        return response()->json([
            'success' => true,
            'message' => 'Code promo supprimé.',
            'total' => number_format($cart->total_amount, 0) . ' AED'
        ]);
    }
}
