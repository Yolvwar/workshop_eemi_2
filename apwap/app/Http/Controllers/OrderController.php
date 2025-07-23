<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Liste des commandes de l'utilisateur
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = $user->orders()->with(['items.product']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('period')) {
            switch ($request->period) {
                case '7days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30days':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case '3months':
                    $query->where('created_at', '>=', now()->subMonths(3));
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }
        
        $orders = $query->paginate(10);
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->whereIn('status', ['confirmed', 'shipped', 'delivered'])->sum('total_amount'),
            'pending_orders' => $user->orders()->pending()->count(),
            'delivered_orders' => $user->orders()->delivered()->count(),
        ];
        
        return view('orders.index', compact('orders', 'stats'));
    }

    /**
     * Détails d'une commande
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product', 'items.pet', 'user']);
        
        $timeline = $this->getOrderTimeline($order);
        
        return view('orders.show', compact('order', 'timeline'));
    }

    /**
     * Suivi de commande (tracking)
     */
    public function track(Order $order)
    {
        $this->authorize('view', $order);
        
        $trackingInfo = $this->getTrackingInfo($order);
        
        return view('orders.track', compact('order', 'trackingInfo'));
    }

    /**
     * Télécharger la facture
     */
    public function downloadInvoice(Order $order)
    {
        $this->authorize('view', $order);
        
         // Génération de la facture PDF ( à faire )

        
        return view('shop.orders.invoice', compact('order'));
    }

    /**
     * Annuler une commande
     */
    public function cancel(Order $order)
    {
        $this->authorize('update', $order);
        
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Cette commande ne peut plus être annulée.');
        }
        
        $order->cancel();
        
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && $product->manage_stock) {
                $product->stock_quantity += $item->quantity;
                $product->save();
            }
        }
        
        return back()->with('success', 'Votre commande a été annulée.');
    }

    /**
     * Racheter les articles d'une commande précédente
     */
    public function reorder(Order $order)
    {
        $this->authorize('view', $order);
        
        $cart = auth()->user()->getOrCreateActiveCart();
        $addedItems = 0;
        
        foreach ($order->items as $item) {
            $product = $item->product;
            
            if ($product && $product->isInStock() && $product->status === 'active') {
                $cart->addItem($product, $item->quantity, $item->pet_id);
                $addedItems++;
            }
        }
        
        if ($addedItems > 0) {
            $message = $addedItems === $order->items->count() 
                ? 'Tous les articles ont été ajoutés à votre panier.'
                : "Seuls {$addedItems} articles disponibles ont été ajoutés à votre panier.";
                
            return redirect()->route('cart')->with('success', $message);
        } else {
            return back()->with('error', 'Aucun article de cette commande n\'est disponible.');
        }
    }

    /**
     * Obtenir la timeline d'une commande
     */
    private function getOrderTimeline(Order $order)
    {
        $timeline = [];
        
        $timeline[] = [
            'status' => 'Commande passée',
            'date' => $order->created_at,
            'icon' => 'shopping-cart',
            'color' => 'blue',
            'completed' => true
        ];
        
        if ($order->status !== 'cancelled') {
            $timeline[] = [
                'status' => 'Paiement confirmé',
                'date' => $order->status !== 'pending' ? $order->updated_at : null,
                'icon' => 'credit-card',
                'color' => 'green',
                'completed' => $order->status !== 'pending'
            ];
            
            $timeline[] = [
                'status' => 'Préparation',
                'date' => in_array($order->status, ['confirmed', 'shipped', 'delivered']) ? $order->updated_at : null,
                'icon' => 'package',
                'color' => 'yellow',
                'completed' => in_array($order->status, ['confirmed', 'shipped', 'delivered'])
            ];
            
            $timeline[] = [
                'status' => 'Expédition',
                'date' => $order->shipped_at,
                'icon' => 'truck',
                'color' => 'purple',
                'completed' => in_array($order->status, ['shipped', 'delivered'])
            ];
            
            $timeline[] = [
                'status' => 'Livraison',
                'date' => $order->delivered_at,
                'icon' => 'check-circle',
                'color' => 'green',
                'completed' => $order->status === 'delivered'
            ];
        } else {
            $timeline[] = [
                'status' => 'Commande annulée',
                'date' => $order->updated_at,
                'icon' => 'x-circle',
                'color' => 'red',
                'completed' => true
            ];
        }
        
        return $timeline;
    }

    /**
     * Obtenir les informations de suivi
     */
    private function getTrackingInfo(Order $order)
    {
        if (!$order->tracking_number) {
            return null;
        }
        
        return [
            'tracking_number' => $order->tracking_number,
            'carrier' => 'APWAP Express',
            'estimated_delivery' => $order->shipped_at ? $order->shipped_at->addDays(2) : null,
            'current_location' => 'Centre de tri Dubai',
            'events' => [
                [
                    'date' => $order->shipped_at,
                    'status' => 'Colis expédié',
                    'location' => 'Entrepôt APWAP Dubai'
                ],
                [
                    'date' => $order->shipped_at ? $order->shipped_at->addHours(2) : null,
                    'status' => 'En transit',
                    'location' => 'Centre de tri Dubai'
                ]
            ]
        ];
    }
}
