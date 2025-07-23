@extends('layouts.shop')

@section('title', 'Commande #' . $order->order_number . ' - Boutique APWAP')
@section('page-title', 'Détails de commande')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900">Commande #{{ $order->order_number }}</h1>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'pending') bg-orange-100 text-orange-800
                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($order->status === 'pending') <x-heroicon-o-clock class="w-4 h-4 inline mr-1" /> En attente
                            @elseif($order->status === 'confirmed') <x-heroicon-o-check-circle class="w-4 h-4 inline mr-1" /> Confirmée
                            @elseif($order->status === 'shipped') <x-heroicon-o-truck class="w-4 h-4 inline mr-1" /> Expédiée
                            @elseif($order->status === 'delivered') <x-heroicon-o-cube class="w-4 h-4 inline mr-1" /> Livrée
                            @elseif($order->status === 'cancelled') <x-heroicon-o-x-circle class="w-4 h-4 inline mr-1" /> Annulée
                            @else {{ ucfirst($order->status) }}
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-600">
                        Passée le {{ 
                            is_string($order->placed_at) 
                                ? \Carbon\Carbon::parse($order->placed_at)->format('d/m/Y à H:i')
                                : $order->placed_at->format('d/m/Y à H:i')
                        }}
                        @if($order->estimated_delivery_date)
                        • Livraison prévue le {{ 
                            is_string($order->estimated_delivery_date) 
                                ? \Carbon\Carbon::parse($order->estimated_delivery_date)->format('d/m/Y')
                                : $order->estimated_delivery_date->format('d/m/Y')
                        }}
                        @endif
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    @if($order->status === 'shipped' || $order->status === 'delivered')
                    <a href="{{ route('orders.track', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        <x-heroicon-o-map-pin class="w-4 h-4 inline mr-2" /> Suivre la livraison
                    </a>
                    @endif
                    
                    @if($order->status === 'delivered')
                    <a href="{{ route('orders.download-invoice', $order) }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors">
                        <x-heroicon-o-document-text class="w-4 h-4 inline mr-2" /> Télécharger facture
                    </a>
                    @endif
                    
                    <a href="{{ route('orders.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        ← Retour aux commandes
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Statut et timeline -->
                @if(in_array($order->status, ['confirmed', 'shipped', 'delivered']))
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6"><x-heroicon-o-calendar-days class="w-5 h-5 inline mr-2" /> Suivi de commande</h2>
                    
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        
                        <!-- Commande passée -->
                        <div class="relative flex items-start space-x-4 pb-8">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                <x-heroicon-o-check class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">Commande passée</h3>
                                <p class="text-sm text-gray-600">{{ 
                                    is_string($order->placed_at) 
                                        ? \Carbon\Carbon::parse($order->placed_at)->format('d/m/Y à H:i')
                                        : $order->placed_at->format('d/m/Y à H:i')
                                }}</p>
                                <p class="text-xs text-gray-500 mt-1">Votre commande a été enregistrée avec succès</p>
                            </div>
                        </div>
                        
                        <!-- Paiement confirmé -->
                        @if($order->payment_status === 'paid')
                        <div class="relative flex items-start space-x-4 pb-8">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                <x-heroicon-o-check class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">Paiement confirmé</h3>
                                <p class="text-sm text-gray-600">{{ 
                                    $order->confirmed_at 
                                        ? (is_string($order->confirmed_at) 
                                            ? \Carbon\Carbon::parse($order->confirmed_at)->format('d/m/Y à H:i')
                                            : $order->confirmed_at->format('d/m/Y à H:i'))
                                        : 'Confirmé' 
                                }}</p>
                                <p class="text-xs text-gray-500 mt-1">Votre paiement a été traité avec succès</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Préparation -->
                        @if(in_array($order->status, ['confirmed', 'shipped', 'delivered']))
                        <div class="relative flex items-start space-x-4 pb-8">
                            <div class="w-8 h-8 {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-600' : 'bg-blue-600' }} rounded-full flex items-center justify-center text-white text-sm font-medium">
                                @if(in_array($order->status, ['shipped', 'delivered']))
                                <x-heroicon-o-check class="w-4 h-4" />
                                @else
                                <x-heroicon-o-clock class="w-4 h-4" />
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">Préparation en cours</h3>
                                <p class="text-sm text-gray-600">
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                    Préparation terminée
                                    @else
                                    En cours de préparation
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Vos articles sont préparés avec soin</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Expédition -->
                        @if(in_array($order->status, ['shipped', 'delivered']))
                        <div class="relative flex items-start space-x-4 pb-8">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                <x-heroicon-o-check class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">Expédiée</h3>
                                <p class="text-sm text-gray-600">{{ 
                                    $order->shipped_at 
                                        ? (is_string($order->shipped_at) 
                                            ? \Carbon\Carbon::parse($order->shipped_at)->format('d/m/Y à H:i')
                                            : $order->shipped_at->format('d/m/Y à H:i'))
                                        : 'Expédiée' 
                                }}</p>
                                <p class="text-xs text-gray-500 mt-1">Votre commande est en route vers vous</p>
                            </div>
                        </div>
                        @elseif($order->status === 'confirmed')
                        <div class="relative flex items-start space-x-4 pb-8">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                                <x-heroicon-o-clock class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-600">En attente d'expédition</h3>
                                <p class="text-sm text-gray-500">Prochaine étape</p>
                                <p class="text-xs text-gray-500 mt-1">Votre commande sera bientôt expédiée</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Livraison -->
                        @if($order->status === 'delivered')
                        <div class="relative flex items-start space-x-4">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                <x-heroicon-o-check class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">Livrée</h3>
                                <p class="text-sm text-gray-600">{{ 
                                    $order->delivered_at 
                                        ? (is_string($order->delivered_at) 
                                            ? \Carbon\Carbon::parse($order->delivered_at)->format('d/m/Y à H:i')
                                            : $order->delivered_at->format('d/m/Y à H:i'))
                                        : 'Livrée' 
                                }}</p>
                                <p class="text-xs text-gray-500 mt-1">Votre commande a été livrée avec succès</p>
                            </div>
                        </div>
                        @else
                        <div class="relative flex items-start space-x-4">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                                <x-heroicon-o-cube class="w-4 h-4" />
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-600">En attente de livraison</h3>
                                <p class="text-sm text-gray-500">
                                    @if($order->estimated_delivery_date)
                                    Prévue le {{ 
                                        is_string($order->estimated_delivery_date) 
                                            ? \Carbon\Carbon::parse($order->estimated_delivery_date)->format('d/m/Y')
                                            : $order->estimated_delivery_date->format('d/m/Y')
                                    }}
                                    @else
                                    Prochaine étape
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Vous recevrez une notification lors de la livraison</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Articles commandés -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6"><x-heroicon-o-shopping-bag class="w-5 h-5 inline mr-2" /> Articles commandés</h2>
                    
                    <div class="space-y-6">
                        @foreach($order->items as $item)
                        <div class="flex items-start space-x-4 pb-6 border-b border-gray-200 last:border-b-0 last:pb-0">
                            @if($item->product && $item->product->images && count($item->product->images) > 0)
                            <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-20 h-20 object-cover rounded-xl">
                            @else
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                <x-heroicon-o-cube class="w-8 h-8 text-gray-400" />
                            </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 mb-1">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">SKU: {{ $item->product_sku }}</p>
                                
                                @if($item->pet)
                                <div class="flex items-center space-x-2 mb-2">
                                    <x-heroicon-o-heart class="w-4 h-4 text-emerald-600" />
                                    <span class="text-sm text-emerald-800 bg-emerald-50 px-2 py-1 rounded-full">
                                        Pour: {{ $item->pet->name }}
                                    </span>
                                </div>
                                @endif
                                
                                @if($item->customization)
                                <div class="text-sm text-gray-600 mb-2">
                                    <span class="font-medium">Personnalisation:</span>
                                    @foreach($item->customization as $key => $value)
                                    <span class="block">{{ ucfirst($key) }}: {{ $value }}</span>
                                    @endforeach
                                </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</span>
                                    <div class="text-right">
                                        <span class="font-semibold text-gray-900">{{ $item->total_price }} AED</span>
                                        <p class="text-sm text-gray-600">{{ $item->unit_price }} AED × {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                
                                @if($order->status === 'delivered' && $item->product)
                                <div class="mt-3">
                                    <a href="{{ route('shop.product', $item->product->slug) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <x-heroicon-o-star class="w-4 h-4 inline mr-1" /> Laisser un avis
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Informations de livraison -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6"><x-heroicon-o-truck class="w-5 h-5 inline mr-2" /> Informations de livraison</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-medium text-gray-900 mb-3">Adresse de livraison</h3>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p class="font-medium">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                                <p>{{ $order->shipping_address_line_1 }}</p>
                                @if($order->shipping_address_line_2)
                                <p>{{ $order->shipping_address_line_2 }}</p>
                                @endif
                                <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                @if($order->shipping_phone)
                                <p class="mt-2"><x-heroicon-o-phone class="w-4 h-4 inline mr-1" /> {{ $order->shipping_phone }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-gray-900 mb-3">Méthode de livraison</h3>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p class="font-medium">
                                    @if($order->shipping_method === 'standard') <x-heroicon-o-cube class="w-4 h-4 inline mr-1" /> Livraison standard
                                    @elseif($order->shipping_method === 'express') <x-heroicon-o-bolt class="w-4 h-4 inline mr-1" /> Livraison express
                                    @elseif($order->shipping_method === 'scheduled') <x-heroicon-o-calendar-days class="w-4 h-4 inline mr-1" /> Livraison programmée
                                    @else {{ ucfirst($order->shipping_method) }}
                                    @endif
                                </p>
                                @if($order->estimated_delivery_date)
                                <p>Livraison prévue: {{ 
                                    is_string($order->estimated_delivery_date) 
                                        ? \Carbon\Carbon::parse($order->estimated_delivery_date)->format('d/m/Y')
                                        : $order->estimated_delivery_date->format('d/m/Y')
                                }}</p>
                                @endif
                                @if($order->shipping_notes)
                                <p class="mt-2 italic">"{{ $order->shipping_notes }}"</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes de commande -->
                @if($order->customer_notes)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4"><x-heroicon-o-document-text class="w-5 h-5 inline mr-2" /> Notes de commande</h2>
                    <p class="text-gray-700 italic">"{{ $order->customer_notes }}"</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <!-- Résumé financier -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4"><x-heroicon-o-calculator class="w-5 h-5 inline mr-2" /> Résumé financier</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ $order->subtotal }} AED</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Réduction</span>
                            <span>-{{ $order->discount_amount }} AED</span>
                        </div>
                        @endif
                        
                        @if($order->coupon_code)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Code promo: {{ $order->coupon_code }}</span>
                            <span class="text-green-600">Appliqué</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-medium">{{ $order->shipping_amount }} AED</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Taxes</span>
                            <span class="font-medium">{{ $order->tax_amount }} AED</span>
                        </div>
                        
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span>{{ $order->total_amount }} AED</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations de paiement -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4"><x-heroicon-o-credit-card class="w-5 h-5 inline mr-2" /> Paiement</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Méthode</span>
                            <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($order->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status === 'pending') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($order->payment_status === 'paid') <x-heroicon-o-check-circle class="w-3 h-3 inline mr-1" /> Payé
                                @elseif($order->payment_status === 'pending') <x-heroicon-o-clock class="w-3 h-3 inline mr-1" /> En attente
                                @else <x-heroicon-o-x-circle class="w-3 h-3 inline mr-1" /> Échec
                                @endif
                            </span>
                        </div>
                        
                        @if($order->payment_reference)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Référence</span>
                            <span class="font-medium text-sm">{{ $order->payment_reference }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4"><x-heroicon-o-bolt class="w-5 h-5 inline mr-2" /> Actions</h3>
                    
                    <div class="space-y-3">
                        @if($order->status === 'delivered')
                        <form action="{{ route('orders.reorder', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                <x-heroicon-o-arrow-path class="w-4 h-4 inline mr-2" /> Recommander
                            </button>
                        </form>
                        @endif
                        
                        @if(in_array($order->status, ['pending', 'confirmed']) && $order->placed_at->diffInHours(now()) < 2)
                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')" 
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                <x-heroicon-o-x-circle class="w-4 h-4 inline mr-2" /> Annuler la commande
                            </button>
                        </form>
                        @endif
                        
                        <a href="mailto:support@apwap.com?subject=Commande #{{ $order->order_number }}" class="block w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium text-center hover:bg-gray-200 transition-colors">
                            <x-heroicon-o-chat-bubble-left-right class="w-4 h-4 inline mr-2" /> Contacter le support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderStatus = '{{ $order->status }}';
        
        if (['pending', 'confirmed', 'shipped'].includes(orderStatus)) {
            setTimeout(() => {
                window.location.reload();
            }, 120000);
        }
    });
</script>
@endpush
@endsection
