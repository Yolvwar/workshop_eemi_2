<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class CheckoutController extends Controller
{   
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Page de commande
     */
    public function index()
    {
        $cart = auth()->user()->getOrCreateActiveCart();
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart')
                           ->with('error', 'Votre panier est vide.');
        }

        $cart->load(['items.product', 'items.pet']);
        $user = auth()->user();

        return view('checkout.index', compact('cart', 'user'));
    }

    /**
     * Traiter la commande
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address_line_1' => 'required|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,apple_pay,wallet,bank_transfer',
            'delivery_type' => 'required|in:standard,express,scheduled',
            'delivery_notes' => 'nullable|string|max:500',
            'terms_accepted' => 'accepted',
            
            'billing_same_as_shipping' => 'boolean',
            'billing_first_name' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_last_name' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_email' => 'required_if:billing_same_as_shipping,false|email|max:255',
            'billing_phone' => 'required_if:billing_same_as_shipping,false|string|max:20',
            'billing_address_line_1' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_address_line_2' => 'nullable|string|max:255',
            'billing_city' => 'required_if:billing_same_as_shipping,false|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'required_if:billing_same_as_shipping,false|string|max:100',
        ]);

        $cart = auth()->user()->getOrCreateActiveCart();
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart')
                           ->with('error', 'Votre panier est vide.');
        }

        foreach ($cart->items as $item) {
            if (!$item->isInStock()) {
                return back()->withErrors([
                    'stock' => "Le produit '{$item->product->name}' n'est plus en stock en quantité suffisante."
                ]);
            }
        }

        try {
            $shippingData = [
                'name' => $request->shipping_first_name . ' ' . $request->shipping_last_name,
                'email' => $request->shipping_email,
                'phone' => $request->shipping_phone,
                'address_line_1' => $request->shipping_address_line_1,
                'address_line_2' => $request->shipping_address_line_2,
                'city' => $request->shipping_city,
                'postal_code' => $request->shipping_postal_code,
                'country' => $request->shipping_country,
            ];

            $billingData = $shippingData;
            if (!$request->billing_same_as_shipping) {
                $billingData = [
                    'name' => $request->billing_first_name . ' ' . $request->billing_last_name,
                    'email' => $request->billing_email,
                    'phone' => $request->billing_phone,
                    'address_line_1' => $request->billing_address_line_1,
                    'address_line_2' => $request->billing_address_line_2,
                    'city' => $request->billing_city,
                    'postal_code' => $request->billing_postal_code,
                    'country' => $request->billing_country,
                ];
            }

            $order = Order::createFromCart($cart, $shippingData, $billingData);
            
            $order->payment_method = $request->payment_method;
            $order->customer_notes = $request->delivery_notes;
            $order->shipping_method = $request->delivery_type;
            $order->save();

            $paymentSuccess = $this->processPayment($order, $request->payment_method);

            if ($paymentSuccess) {
                $order->confirm();
                
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product && $product->manage_stock) {
                        $product->stock_quantity -= $item->quantity;
                        $product->save();
                    }
                }

                return redirect()->route('orders.success', $order)
                               ->with('success', 'Votre commande a été confirmée !');
            } else {
                $order->cancel();
                return back()->withErrors(['payment' => 'Erreur lors du paiement. Veuillez réessayer.']);
            }

        } catch (\Exception $e) {
            \Log::error('Erreur lors du checkout: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }

    /**
     * Page de succès après commande
     */
    public function success(Order $order)
    {
        if (!auth()->check() || $order->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé à cette commande');
        }
        
        $order->load(['items.product', 'items.pet']);
        
        return view('orders.success', compact('order'));
    }

    /**
     * Simuler le traitement du paiement
     * Dans un vrai projet, intégrez votre processeur de paiement ici
     */
    private function processPayment(Order $order, string $paymentMethod)
    {
        
        switch ($paymentMethod) {
            case 'card':
                return true;
                
            case 'apple_pay':
                return true;
                
            case 'wallet':
                return true;
                
            case 'bank_transfer':
                $order->payment_status = 'pending';
                $order->save();
                return true;
                
            default:
                return false;
        }
    }

    /**
     * Calculer les frais de livraison en temps réel
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'delivery_type' => 'required|in:standard,express,scheduled',
            'city' => 'required|string'
        ]);

        $cart = auth()->user()->getOrCreateActiveCart();
        $shippingCost = 0;

        if ($cart->subtotal >= 500) {
            $shippingCost = 0;
        } else {
            switch ($request->delivery_type) {
                case 'express':
                    $shippingCost = 50;
                    break;
                case 'scheduled':
                    $shippingCost = 25;
                    break;
                default:
                    $shippingCost = 0;
            }
        }

        return response()->json([
            'shipping_cost' => $shippingCost,
            'shipping_cost_formatted' => number_format($shippingCost, 0) . ' AED',
            'total' => number_format($cart->subtotal + $shippingCost - $cart->discount_amount, 0) . ' AED'
        ]);
    }

    /**
     * Valider le code promo
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);


        $validCoupons = [
            'WELCOME10' => ['discount' => 10, 'type' => 'percentage'],
            'SUMMER20' => ['discount' => 20, 'type' => 'percentage'],
            'SAVE50' => ['discount' => 50, 'type' => 'fixed'],
        ];

        $couponCode = strtoupper($request->coupon_code);
        
        if (isset($validCoupons[$couponCode])) {
            return response()->json([
                'valid' => true,
                'discount' => $validCoupons[$couponCode]['discount'],
                'type' => $validCoupons[$couponCode]['type']
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Code promo invalide'
        ]);
    }
}
