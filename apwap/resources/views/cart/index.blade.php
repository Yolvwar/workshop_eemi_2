@extends('layouts.shop')

@section('title', 'Panier - Boutique APWAP')
@section('page-title', 'Mon Panier')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header avec breadcrumb -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Boutique</a></li>
                    <li class="flex items-center"><svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-gray-900 font-medium">Mon Panier</li>
                </ol>
            </nav>
            
            <!-- Header principal -->
            <div class="flex items-center justify-between">
                <div>                        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        Mon Panier
                        @if($cart->items->count() > 0)
                        <span class="bg-emerald-100 text-emerald-800 text-lg px-3 py-1 rounded-full" data-cart-count>{{ $cart->items_count }}</span>
                        @endif
                    </h1>
                    @if($cart->items->count() > 0)
                    <p class="text-gray-600 mt-2"><span data-items-count>{{ $cart->items_count }} {{ $cart->items_count > 1 ? 'articles' : 'article' }}</span> • Total: <span class="font-semibold text-emerald-600" data-total>{{ $cart->total_amount }} AED</span></p>
                    @endif
                </div>
                
                @if($cart->items->count() > 0)
                <!-- Actions rapides -->
                <div class="flex items-center space-x-3">
                    <button onclick="clearCart()" class="text-sm text-gray-600 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Vider le panier
                    </button>
                    <button onclick="saveCart()" class="text-sm text-gray-600 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Sauvegarder
                    </button>
                </div>
                @endif
            </div>
        </div>

        @if($cart->items->count() > 0)
        <!-- Barre de progression vers livraison gratuite -->
        @if($cart->subtotal < 500)
        <div class="mb-6 bg-gradient-to-r from-blue-50 to-emerald-50 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">🚚 Livraison gratuite à partir de 500 AED</span>
                <span class="text-sm font-bold text-emerald-600" data-remaining-amount>{{ 500 - $cart->subtotal }} AED restants</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2" data-shipping-indicator>
                <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-2 rounded-full transition-all duration-300" style="width: {{ min(($cart->subtotal / 500) * 100, 100) }}%"></div>
            </div>
            <p class="text-xs text-gray-600 mt-1">Ajoutez encore quelques articles pour profiter de la livraison gratuite !</p>
        </div>
        @else
        <div class="mb-6 bg-green-50 rounded-xl p-4 border border-green-200">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-green-800 font-medium">🎉 Félicitations ! Vous bénéficiez de la livraison gratuite</span>
            </div>
        </div>
        @endif
        
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Articles du panier -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <!-- Image produit avec lien -->
                            <div class="flex-shrink-0">
                                <a href="{{ route('shop.product', $item->product->slug) }}" class="block group">
                                    @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-xl group-hover:scale-105 transition-transform duration-200">
                                    @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <span class="text-3xl">📦</span>
                                    </div>
                                    @endif
                                    <!-- Badge de stock si faible -->
                                    @if($item->product->stock_quantity <= 5)
                                    <div class="mt-1 text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-center">
                                        Stock: {{ $item->product->stock_quantity }}
                                    </div>
                                    @endif
                                </a>
                            </div>
                            
                            <!-- Informations produit restructurées -->
                            <div class="flex-1 min-w-0">
                                <!-- En-tête produit -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            <a href="{{ route('shop.product', $item->product->slug) }}" class="hover:text-emerald-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center space-x-3 text-sm text-gray-600">
                                            <span class="bg-gray-100 px-2 py-1 rounded-full">{{ $item->product->category->name }}</span>
                                            @if($item->product->brand)
                                            <span>{{ $item->product->brand }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Prix mis en évidence -->
                                    <div class="text-right ml-4">
                                        <div class="text-xl font-bold text-gray-900" data-item-total-{{ $item->id }}>{{ $item->total_price }} AED</div>
                                        <div class="text-sm text-gray-600" data-item-unit-{{ $item->id }}>{{ $item->unit_price }} AED × {{ $item->quantity }}</div>
                                        @if($item->product->original_price && $item->product->original_price > $item->unit_price)
                                        <div class="text-sm text-green-600 font-medium" data-item-savings-{{ $item->id }}>
                                            Économie: {{ ($item->product->original_price - $item->unit_price) * $item->quantity }} AED
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Animal associé avec design amélioré -->
                                @if($item->pet)
                                <div class="flex items-center space-x-2 mb-4">
                                    <div class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                                        <span>🐾</span>
                                        <span>Pour: {{ $item->pet->name }}</span>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Contrôles de quantité améliorés -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <!-- Quantité avec design moderne -->
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-medium text-gray-700">Quantité:</span>
                                            <div class="flex items-center bg-gray-100 rounded-lg">
                                                <button type="button" onclick="decrementQuantity('{{ $item->id }}')" 
                                                        class="w-10 h-10 bg-gray-100 text-gray-600 rounded-l-lg hover:bg-gray-200 transition-colors flex items-center justify-center"
                                                        data-item-id="{{ $item->id }}" data-action="decrement">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                                       class="w-16 h-10 text-center border-0 bg-white text-gray-900 font-medium focus:ring-2 focus:ring-emerald-500"
                                                       data-item-id="{{ $item->id }}" data-original-value="{{ $item->quantity }}"
                                                       onchange="handleManualQuantityChange('{{ $item->id }}', this.value)">
                                                <button type="button" onclick="incrementQuantity('{{ $item->id }}')" 
                                                        class="w-10 h-10 bg-gray-100 text-gray-600 rounded-r-lg hover:bg-gray-200 transition-colors flex items-center justify-center"
                                                        data-item-id="{{ $item->id }}" data-action="increment">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions avec icônes améliorées -->
                                    <div class="flex items-center space-x-3">
                                        <button onclick="saveForLater('{{ $item->id }}')" class="flex items-center space-x-1 text-sm text-gray-600 hover:text-emerald-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span>Sauvegarder</span>
                                        </button>
                                        <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <button type="submit" class="flex items-center space-x-1 text-sm text-red-600 hover:text-red-700 transition-colors"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <span>Supprimer</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Options supplémentaires avec design amélioré -->
                                @if($item->customization || $item->product->subscription_available)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex flex-wrap gap-2">
                                        @if($item->product->subscription_available)
                                        <button onclick="toggleSubscription('{{ $item->id }}')" class="flex items-center space-x-1 text-xs bg-purple-50 text-purple-700 px-3 py-2 rounded-lg hover:bg-purple-100 transition-colors border border-purple-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span>Abonnement (-10%)</span>
                                        </button>
                                        @endif
                                        <button onclick="addGiftWrap('{{ $item->id }}')" class="flex items-center space-x-1 text-xs bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg hover:bg-yellow-100 transition-colors border border-yellow-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                            </svg>
                                            <span>Emballage cadeau (+25 AED)</span>
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

               

            <!-- Résumé de commande amélioré -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-2xl shadow-lg sticky top-8">
                    <!-- En-tête du résumé -->
                    <div class="bg-gradient-to-r from-emerald-50 to-blue-50 p-6 rounded-t-2xl border-b">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Résumé de commande
                        </h3>
                        <p class="text-sm text-gray-600 mt-1" data-items-count-summary>{{ $cart->items_count }} article{{ $cart->items_count > 1 ? 's' : '' }} dans votre panier</p>
                    </div>
                    
                    <div class="p-6">
                        <!-- Détails des coûts avec design amélioré -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="text-gray-700">Sous-total</span>
                                </div>
                                <span class="font-semibold text-gray-900" data-subtotal>{{ $cart->subtotal }} AED</span>
                            </div>
                            
                            @if($cart->discount_amount > 0)
                            <div class="flex items-center justify-between py-2 bg-green-50 px-3 rounded-lg">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-green-700 font-medium">Réduction</span>
                                </div>
                                <span class="font-semibold text-green-600">-{{ $cart->discount_amount }} AED</span>
                            </div>
                            @endif
                            
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span class="text-gray-700">Livraison</span>
                                </div>
                                <div class="text-right">
                                    @if($cart->subtotal >= 500)
                                        <span class="font-semibold text-green-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Gratuite
                                        </span>
                                    @else
                                        <span class="font-semibold text-gray-900">{{ $cart->shipping_amount ?? 25 }} AED</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Indicateur livraison gratuite -->
                            @if($cart->subtotal < 500)
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">Livraison gratuite à partir de 500 AED</p>
                                        <p class="text-xs text-blue-600 mt-1">
                                            Plus que <span class="font-semibold">{{ 500 - $cart->subtotal }} AED</span> pour en bénéficier
                                        </p>
                                        <div class="w-full bg-blue-200 rounded-full h-2 mt-2">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ min(($cart->subtotal / 500) * 100, 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-700">Taxes (TVA 5%)</span>
                                </div>
                                <span class="font-semibold text-gray-900">{{ $cart->tax_amount }} AED</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">Total à payer</span>
                                    <span class="text-2xl font-bold text-emerald-600" data-total-main>{{ $cart->total_amount }} AED</span>
                                </div>
                            </div>
                        </div>

                        <!-- Code promo amélioré -->
                        <div class="mb-6">
                            @if($cart->coupon_code)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span class="text-green-800 font-medium">{{ $cart->coupon_code }}</span>
                                    </div>
                                    <form action="{{ route('cart.remove-coupon') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-700 p-1 rounded-full hover:bg-green-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <form action="{{ route('cart.apply-coupon') }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div class="flex items-center space-x-2 mb-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Code promo</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <input type="text" name="coupon_code" placeholder="Entrez votre code" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                                            Appliquer
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>

                        <!-- Actions principales avec design amélioré -->
                        <div class="space-y-3 mb-6">
                            <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-4 px-6 rounded-lg font-semibold text-center hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span>Finaliser ma commande</span>
                                </div>
                            </a>
                            
                            <a href="{{ route('shop.catalog') }}" class="block w-full bg-white text-emerald-600 py-3 px-6 rounded-lg font-semibold text-center border-2 border-emerald-600 hover:bg-emerald-50 transition-all duration-300">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    <span>Continuer mes achats</span>
                                </div>
                            </a>
                        </div>

                        <!-- Garanties et sécurité -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Vos garanties</h4>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Paiement sécurisé SSL</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Livraison express disponible</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">Retour gratuit sous 30 jours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @else
        <!-- Panier vide -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="text-6xl mb-6">🛒</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
                <p class="text-gray-600 mb-8">Découvrez nos produits premium pour vos compagnons et commencez vos achats.</p>
                
                <!-- Suggestions de catégories -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <a href="{{ route('shop.category', 'nutrition') }}" class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="text-3xl mb-2">🍽️</div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Nutrition</h3>
                        <p class="text-sm text-gray-600">Croquettes & alimentation</p>
                    </a>
                    
                    <a href="{{ route('shop.category', 'sante') }}" class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="text-3xl mb-2">🏥</div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Santé</h3>
                        <p class="text-sm text-gray-600">Soins & médicaments</p>
                    </a>
                    
                    <a href="{{ route('shop.category', 'jouets') }}" class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="text-3xl mb-2">🎾</div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Jouets</h3>
                        <p class="text-sm text-gray-600">Jeux & accessoires</p>
                    </a>
                    
                    <a href="{{ route('shop.category', 'confort') }}" class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 group">
                        <div class="text-3xl mb-2">🛏️</div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Confort</h3>
                        <p class="text-sm text-gray-600">Lits & coussins</p>
                    </a>
                </div>
                
                <div class="space-y-3">
                    <a href="{{ route('shop.index') }}" class="block bg-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-emerald-700 transition-colors">
                        🛍️ Découvrir la boutique
                    </a>
                    
                    @auth
                    @if(auth()->user()->pets->count() > 0)
                    <a href="{{ route('shop.pet.recommendations', auth()->user()->pets->first()) }}" class="block bg-white text-emerald-600 px-8 py-3 rounded-full font-semibold border-2 border-emerald-600 hover:bg-emerald-50 transition-colors">
                        🎯 Voir les recommandations pour {{ auth()->user()->pets->first()->name }}
                    </a>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const cartConfig = {
        updateUrl: '{{ route("cart.update") }}',
        applyCouponUrl: '{{ route("cart.apply-coupon") }}',
        removeCouponUrl: '{{ route("cart.remove-coupon") }}',
        csrfToken: '{{ csrf_token() }}',
        isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
        debug: {{ app()->environment('local') ? 'true' : 'false' }}
    };

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    function setLoadingState(button, isLoading) {
        if (isLoading) {
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Chargement...
            `;
        } else {
            button.disabled = false;
        }
    }


    let isUpdatingQuantity = false;
    let quantityDebounceTimeout = null;

    function incrementQuantity(itemId) {
        if (isUpdatingQuantity) {
            console.log('⏸ Operation already in progress, skipping...');
            return;
        }
        
        const input = document.querySelector(`input[data-item-id="${itemId}"]`);
        if (!input) {
            console.error('❌ Input not found for item:', itemId);
            return;
        }
        
        const currentValue = parseInt(input.value) || 1;
        const maxValue = parseInt(input.getAttribute('max')) || 999;
        const newValue = Math.min(currentValue + 1, maxValue);
        
        console.log(`➕ Increment: ${itemId} from ${currentValue} to ${newValue}`);
        
        if (newValue <= maxValue) {
            updateQuantityValue(itemId, newValue);
        } else {
            showToast('Stock maximum atteint', 'error');
        }
    }

    function decrementQuantity(itemId) {
        if (isUpdatingQuantity) {
            console.log('⏸ Operation already in progress, skipping...');
            return;
        }
        
        const input = document.querySelector(`input[data-item-id="${itemId}"]`);
        if (!input) {
            console.error('❌ Input not found for item:', itemId);
            return;
        }
        
        const currentValue = parseInt(input.value) || 1;
        const minValue = parseInt(input.getAttribute('min')) || 1;
        const newValue = Math.max(currentValue - 1, minValue);
        
        console.log(`➖ Decrement: ${itemId} from ${currentValue} to ${newValue}`);
        
        if (newValue >= minValue) {
            updateQuantityValue(itemId, newValue);
        } else {
            showToast('Quantité minimum atteinte', 'error');
        }
    }

    function handleManualQuantityChange(itemId, newValue) {
        if (isUpdatingQuantity) {
            console.log('⏸ Manual change ignored, operation in progress...');
            return;
        }
        
        const value = parseInt(newValue) || 1;
        console.log(`✏ Manual change: ${itemId} to ${value}`);
        
        const input = document.querySelector(`input[data-item-id="${itemId}"]`);
        const minValue = parseInt(input.getAttribute('min')) || 1;
        const maxValue = parseInt(input.getAttribute('max')) || 999;
        
        if (value < minValue) {
            input.value = minValue;
            showToast(`Quantité minimum: ${minValue}`, 'error');
            return;
        }
        
        if (value > maxValue) {
            input.value = maxValue;
            showToast(`Stock disponible: ${maxValue}`, 'error');
            return;
        }
        
        updateQuantityValue(itemId, value);
    }

    function updateQuantityValue(itemId, newQuantity) {
        if (isUpdatingQuantity) {
            console.log('⏸ Update already in progress...');
            return;
        }
        
        console.log(`🔄 Updating quantity for item ${itemId} to ${newQuantity}`);
        
        isUpdatingQuantity = true;
        
        const input = document.querySelector(`input[data-item-id="${itemId}"]`);
        const incrementBtn = document.querySelector(`button[data-item-id="${itemId}"][data-action="increment"]`);
        const decrementBtn = document.querySelector(`button[data-item-id="${itemId}"][data-action="decrement"]`);
        
        if (!input) {
            console.error('❌ Input not found');
            isUpdatingQuantity = false;
            return;
        }
        
        const originalValue = parseInt(input.value) || 1;
        
        input.value = newQuantity;
        
        updateItemDisplayOptimistic(itemId, newQuantity);
        updateCartTotalsOptimistic();
        
        if (incrementBtn) incrementBtn.disabled = true;
        if (decrementBtn) decrementBtn.disabled = true;
        input.disabled = true;
        
        input.classList.add('animate-pulse', 'bg-gray-100');
        
        clearTimeout(quantityDebounceTimeout);
        quantityDebounceTimeout = setTimeout(() => {
            fetch(cartConfig.updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': cartConfig.csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: newQuantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('✅ Server confirmed update');
                    showToast(`Quantité: ${newQuantity}`, 'success');
                    
                    if (data.cart) {
                        updateCartTotalsFromServer(data.cart);
                    }
                } else {
                    throw new Error(data.message || 'Erreur serveur');
                }
            })
            .catch(error => {
                console.error('❌ Server error:', error);
                showToast('Erreur de mise à jour', 'error');
                
                input.value = originalValue;
                updateItemDisplayOptimistic(itemId, originalValue);
                updateCartTotalsOptimistic();
            })
            .finally(() => {
                if (incrementBtn) incrementBtn.disabled = false;
                if (decrementBtn) decrementBtn.disabled = false;
                input.disabled = false;
                
                input.classList.remove('animate-pulse', 'bg-gray-100');
                
                isUpdatingQuantity = false;
                
                console.log('🏁 Quantity update completed');
            });
        }, 300);
    }


        console.log(`🎨 Updating display for item ${itemId} with quantity ${newQuantity}`);
        
        const itemTotalElement = document.querySelector(`[data-item-total-${itemId}]`);
        const itemUnitElement = document.querySelector(`[data-item-unit-${itemId}]`);
        const itemSavingsElement = document.querySelector(`[data-item-savings-${itemId}]`);
        
        if (itemUnitElement && itemTotalElement) {
            const unitText = itemUnitElement.textContent;
            const unitPriceMatch = unitText.match(/(\d+(?:\.\d+)?)/);
            
            if (unitPriceMatch) {
                const unitPrice = parseFloat(unitPriceMatch[1]);
                const newTotal = unitPrice * newQuantity;
                
                itemTotalElement.textContent = `${newTotal} AED`;
                itemUnitElement.textContent = `${unitPrice} AED × ${newQuantity}`;
                
                if (itemSavingsElement) {
                    const savingsText = itemSavingsElement.textContent;
                    const savingsMatch = savingsText.match(/(\d+(?:\.\d+)?)/);
                    if (savingsMatch) {
                        const originalSavingsTotal = parseFloat(savingsMatch[1]);
                        const originalQuantity = parseInt(unitText.match(/× (\d+)/)?.[1] || 1);
                        const savingsPerUnit = originalSavingsTotal / originalQuantity;
                        const newSavings = savingsPerUnit * newQuantity;
                        itemSavingsElement.textContent = `Économie: ${newSavings.toFixed(0)} AED`;
                    }
                }
                
                console.log(`✅ Item display updated: ${unitPrice} × ${newQuantity} = ${newTotal}`);
            }
        }
    }

    function updateCartTotalsOptimistic() {
        console.log('🧮 Calculating optimistic cart totals...');
        
        let totalQuantity = 0;
        let estimatedSubtotal = 0;
        
        const quantityInputs = document.querySelectorAll('input[data-item-id]');
        
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const itemId = input.getAttribute('data-item-id');
            totalQuantity += quantity;
            
            const unitElement = document.querySelector(`[data-item-unit-${itemId}]`);
            if (unitElement) {
                const unitText = unitElement.textContent;
                const unitPriceMatch = unitText.match(/(\d+(?:\.\d+)?)/);
                if (unitPriceMatch) {
                    const unitPrice = parseFloat(unitPriceMatch[1]);
                    estimatedSubtotal += unitPrice * quantity;
                }
            }
        });
        
        const shippingCost = estimatedSubtotal >= 500 ? 0 : 25;
        const taxAmount = estimatedSubtotal * 0.05;
        const totalAmount = estimatedSubtotal + shippingCost + taxAmount;
        
        console.log(`📊 Optimistic totals: ${totalQuantity} items, ${estimatedSubtotal} subtotal, ${totalAmount} total`);
        
        updateCartDisplayElements({
            items_count: totalQuantity,
            subtotal: estimatedSubtotal.toFixed(2),
            shipping_amount: shippingCost,
            tax_amount: taxAmount.toFixed(2),
            total_amount: totalAmount.toFixed(2)
        });
    }

    function updateCartTotalsFromServer(cartData) {
        console.log('📊 Updating from server data:', cartData);
        updateCartDisplayElements(cartData);
        updateShippingIndicator(parseFloat(cartData.subtotal));
    }

    function updateCartDisplayElements(cart) {
        document.querySelectorAll('[data-subtotal]').forEach(el => {
            el.textContent = `${cart.subtotal} AED`;
        });
        
        document.querySelectorAll('[data-total-main]').forEach(el => {
            el.textContent = `${cart.total_amount} AED`;
        });
        
        document.querySelectorAll('[data-total]').forEach(el => {
            el.textContent = `${cart.total_amount} AED`;
        });
        
        document.querySelectorAll('[data-items-count]').forEach(el => {
            const count = cart.items_count;
            el.textContent = `${count} article${count > 1 ? 's' : ''}`;
        });
        
        document.querySelectorAll('[data-items-count-summary]').forEach(el => {
            const count = cart.items_count;
            el.textContent = `${count} article${count > 1 ? 's' : ''} dans votre panier`;
        });
        
        document.querySelectorAll('[data-cart-count]').forEach(el => {
            el.textContent = cart.items_count;
        });
    }

    function submitQuantityForm(itemId, newQuantity) {
        showToast('Utilisation du mode de sauvegarde...', 'info');
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = cartConfig.updateUrl;
        
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = cartConfig.csrfToken;
        
        const itemIdField = document.createElement('input');
        itemIdField.type = 'hidden';
        itemIdField.name = 'item_id';
        itemIdField.value = itemId;
        
        const quantityField = document.createElement('input');
        quantityField.type = 'hidden';
        quantityField.name = 'quantity';
        quantityField.value = newQuantity;
        
        form.appendChild(csrfField);
        form.appendChild(itemIdField);
        form.appendChild(quantityField);
        
        document.body.appendChild(form);
        form.submit();
    }

    function updateCartTotals(cart) {
        console.log('🔄 Starting cart totals update with data:', cart);
        
        const elementsFound = {
            subtotal: 0,
            totalMain: 0,
            total: 0,
            itemsCount: 0,
            itemsCountSummary: 0,
            cartCount: 0
        };
        
        const subtotalElements = document.querySelectorAll('[data-subtotal]');
        elementsFound.subtotal = subtotalElements.length;
        console.log(`Found ${subtotalElements.length} subtotal elements`);
        subtotalElements.forEach((el, index) => {
            console.log(`Updating subtotal element ${index}:`, el);
            el.textContent = `${cart.subtotal} AED`;
            el.classList.add('animate-pulse', 'text-emerald-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-emerald-600'), 500);
        });
        
        const totalMainElements = document.querySelectorAll('[data-total-main]');
        elementsFound.totalMain = totalMainElements.length;
        console.log(`Found ${totalMainElements.length} total-main elements`);
        totalMainElements.forEach((el, index) => {
            console.log(`Updating total-main element ${index}:`, el);
            el.textContent = `${cart.total_amount} AED`;
            el.classList.add('animate-pulse', 'text-emerald-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-emerald-600'), 500);
        });
        
        const totalElements = document.querySelectorAll('[data-total]');
        elementsFound.total = totalElements.length;
        console.log(`Found ${totalElements.length} total elements`);
        totalElements.forEach((el, index) => {
            console.log(`Updating total element ${index}:`, el);
            el.textContent = `${cart.total_amount} AED`;
            el.classList.add('animate-pulse', 'text-emerald-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-emerald-600'), 500);
        });
        
        const itemCountElements = document.querySelectorAll('[data-items-count]');
        elementsFound.itemsCount = itemCountElements.length;
        console.log(`Found ${itemCountElements.length} items-count elements`);
        itemCountElements.forEach((el, index) => {
            const count = cart.items_count;
            console.log(`Updating items-count element ${index} with count ${count}:`, el);
            el.textContent = `${count} article${count > 1 ? 's' : ''}`;
            el.classList.add('animate-pulse', 'text-blue-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-blue-600'), 500);
        });
        
        const itemCountSummaryElements = document.querySelectorAll('[data-items-count-summary]');
        elementsFound.itemsCountSummary = itemCountSummaryElements.length;
        console.log(`Found ${itemCountSummaryElements.length} items-count-summary elements`);
        itemCountSummaryElements.forEach((el, index) => {
            const count = cart.items_count;
            console.log(`Updating items-count-summary element ${index} with count ${count}:`, el);
            el.textContent = `${count} article${count > 1 ? 's' : ''} dans votre panier`;
            el.classList.add('animate-pulse', 'text-blue-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-blue-600'), 500);
        });
        
        const cartCountElements = document.querySelectorAll('[data-cart-count]');
        elementsFound.cartCount = cartCountElements.length;
        console.log(`Found ${cartCountElements.length} cart-count elements`);
        cartCountElements.forEach((el, index) => {
            console.log(`Updating cart-count element ${index} with count ${cart.items_count}:`, el);
            el.textContent = cart.items_count;
            el.classList.add('animate-pulse', 'text-emerald-600');
            setTimeout(() => el.classList.remove('animate-pulse', 'text-emerald-600'), 500);
        });
        
        console.log('📊 Elements found summary:', elementsFound);
        
        updateShippingIndicator(cart.subtotal);
        
        showToast(`Panier mis à jour: ${cart.items_count} article${cart.items_count > 1 ? 's' : ''} • ${cart.total_amount} AED`, 'success');
        
        console.log('✅ Cart totals update completed');
    }

    function updateShippingIndicator(subtotal) {
        const freeShippingThreshold = 500;
        const remaining = Math.max(freeShippingThreshold - subtotal, 0);
        
        console.log(`Updating shipping indicator: subtotal=${subtotal}, remaining=${remaining}`);
        
        const remainingAmountElements = document.querySelectorAll('[data-remaining-amount]');
        remainingAmountElements.forEach(el => {
            el.textContent = `${remaining} AED restants`;
        });
        
        const progressIndicators = document.querySelectorAll('[data-shipping-indicator]');
        progressIndicators.forEach(indicator => {
            const progressBar = indicator.querySelector('.bg-gradient-to-r');
            if (progressBar) {
                const progress = Math.min((subtotal / freeShippingThreshold) * 100, 100);
                progressBar.style.width = `${progress}%`;
                console.log(`Progress bar updated to ${progress}%`);
            }
        });
        
        const detailledIndicator = document.querySelector('.bg-gradient-to-r.from-blue-50.to-indigo-50');
        if (detailledIndicator && remaining > 0) {
            const remainingSpan = detailledIndicator.querySelector('span.font-semibold');
            if (remainingSpan) {
                remainingSpan.textContent = `${remaining} AED`;
            }
            
            const detailledProgressBar = detailledIndicator.querySelector('.bg-blue-600');
            if (detailledProgressBar) {
                const progress = Math.min((subtotal / freeShippingThreshold) * 100, 100);
                detailledProgressBar.style.width = `${progress}%`;
            }
        }
        
        if (remaining === 0) {
            showToast('🎉 Livraison gratuite obtenue !', 'success');
        }
    }

    function saveForLater(itemId) {
        const button = document.querySelector(`button[onclick*="saveForLater('${itemId}')"]`);
        setLoadingState(button, true);
        
        setTimeout(() => {
            showToast('Article sauvegardé pour plus tard', 'success');
            setLoadingState(button, false);
            button.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Sauvegardé</span>
            `;
            button.classList.add('text-green-600');
        }, 1000);
    }

    function toggleSubscription(itemId) {
        const button = document.querySelector(`button[onclick*="toggleSubscription('${itemId}')"]`);
        const isActive = button.classList.contains('bg-purple-100');
        
        if (isActive) {
            button.classList.remove('bg-purple-100', 'text-purple-700');
            button.classList.add('bg-gray-100', 'text-gray-700');
            showToast('Abonnement désactivé', 'info');
        } else {
            button.classList.remove('bg-gray-100', 'text-gray-700');
            button.classList.add('bg-purple-100', 'text-purple-700');
            showToast('Abonnement activé (-10%)', 'success');
        }
    }

    function addGiftWrap(itemId) {
        const button = document.querySelector(`button[onclick*="addGiftWrap('${itemId}')"]`);
        const isActive = button.classList.contains('bg-yellow-100');
        
        if (isActive) {
            button.classList.remove('bg-yellow-100', 'text-yellow-700');
            button.classList.add('bg-gray-100', 'text-gray-700');
            button.innerHTML = button.innerHTML.replace('Ajouté', 'Emballage cadeau (+25 AED)');
            showToast('Emballage cadeau retiré', 'info');
        } else {
            button.classList.remove('bg-gray-100', 'text-gray-700');
            button.classList.add('bg-yellow-100', 'text-yellow-700');
            button.innerHTML = button.innerHTML.replace('Emballage cadeau (+25 AED)', 'Ajouté');
            showToast('Emballage cadeau ajouté (+25 AED)', 'success');
        }
    }

    function confirmRemoval(itemName) {
        return new Promise((resolve) => {
            const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer "${itemName}" de votre panier ?`);
            resolve(confirmed);
        });
    }

    function clearCart() {
        if (confirm('Êtes-vous sûr de vouloir vider complètement votre panier ?')) {
            showToast('Fonctionnalité de vidage du panier en cours de développement', 'info');
        }
    }

    function saveCart() {
        showToast('Panier sauvegardé avec succès', 'success');
        localStorage.setItem('saved_cart', JSON.stringify({
            timestamp: Date.now(),
            url: window.location.href
        }));
    }

    let autoSaveTimeout;
    function autoSaveCart() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            const cartData = {
                timestamp: Date.now(),
                items: Array.from(document.querySelectorAll('input[name="quantity"]')).map(input => ({
                    id: input.getAttribute('onchange').match(/'([^']+)'/)[1],
                    quantity: input.value
                }))
            };
            
            localStorage.setItem('cart_draft', JSON.stringify(cartData));
            console.log('Panier sauvegardé automatiquement');
        }, 2000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔧 Cart Configuration:', cartConfig);
        console.log('🌐 Current URL:', window.location.href);
        
        console.log('🔍 Cart elements audit:');
        console.log('Subtotal elements:', document.querySelectorAll('[data-subtotal]').length);
        console.log('Total elements:', document.querySelectorAll('[data-total]').length);
        console.log('Total-main elements:', document.querySelectorAll('[data-total-main]').length);
        console.log('Items-count elements:', document.querySelectorAll('[data-items-count]').length);
        console.log('Items-count-summary elements:', document.querySelectorAll('[data-items-count-summary]').length);
        console.log('Cart-count elements:', document.querySelectorAll('[data-cart-count]').length);
        console.log('Shipping indicator elements:', document.querySelectorAll('[data-shipping-indicator]').length);
        console.log('Remaining amount elements:', document.querySelectorAll('[data-remaining-amount]').length);
        
        console.log('📋 Current values:');
        document.querySelectorAll('[data-subtotal]').forEach((el, i) => {
            console.log(`Subtotal ${i}:`, el.textContent, el);
        });
        document.querySelectorAll('[data-total]').forEach((el, i) => {
            console.log(`Total ${i}:`, el.textContent, el);
        });
        document.querySelectorAll('[data-total-main]').forEach((el, i) => {
            console.log(`Total-main ${i}:`, el.textContent, el);
        });
        document.querySelectorAll('[data-items-count]').forEach((el, i) => {
            console.log(`Items-count ${i}:`, el.textContent, el);
        });
        document.querySelectorAll('[data-items-count-summary]').forEach((el, i) => {
            console.log(`Items-count-summary ${i}:`, el.textContent, el);
        });
        
        if (cartConfig.debug) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' || mutation.type === 'characterData') {
                        const target = mutation.target;
                        if (target.hasAttribute && (
                            target.hasAttribute('data-subtotal') || 
                            target.hasAttribute('data-total') || 
                            target.hasAttribute('data-total-main') || 
                            target.hasAttribute('data-items-count') || 
                            target.hasAttribute('data-cart-count')
                        )) {
                            console.log('🔄 DOM Update detected:', {
                                element: target.tagName,
                                attribute: Object.keys(target.dataset)[0],
                                newValue: target.textContent,
                                timestamp: new Date().toLocaleTimeString()
                            });
                        }
                    }
                });
            });
            
            document.querySelectorAll('[data-subtotal], [data-total], [data-total-main], [data-items-count], [data-cart-count]').forEach(el => {
                observer.observe(el, { childList: true, characterData: true, subtree: true });
            });
        }
        
        const quantityInputs = document.querySelectorAll('input[type="number"]');
        console.log('📊 Found quantity inputs:', quantityInputs.length);
        
        quantityInputs.forEach((input, index) => {
            console.log(`Input ${index}:`, input.getAttribute('onchange'));
            input.addEventListener('input', autoSaveCart);
            
            input.addEventListener('input', function() {
                const min = parseInt(this.min) || 1;
                const max = parseInt(this.max) || 999;
                const value = parseInt(this.value);
                
                if (value < min) {
                    this.value = min;
                    showToast(`Quantité minimum: ${min}`, 'error');
                } else if (value > max) {
                    this.value = max;
                    showToast(`Stock disponible: ${max}`, 'error');
                }
            });
        });

        const removeButtons = document.querySelectorAll('form[action*="cart.remove"] button[type="submit"]');
        console.log('Found remove buttons:', removeButtons.length);
        
        removeButtons.forEach((button, index) => {
            console.log(`Remove button ${index}:`, button);
            button.removeAttribute('onclick');
            
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Remove button clicked');
                
                const productCard = this.closest('.bg-white.rounded-xl');
                const productLink = productCard ? productCard.querySelector('h3 a') : null;
                const productName = productLink ? productLink.textContent.trim() : 'cet article';
                
                console.log('Product name:', productName);
                
                const confirmed = await showConfirmModal(
                    'Supprimer l\'article',
                    `Êtes-vous sûr de vouloir supprimer "${productName}" de votre panier ?`,
                    'Cette action est irréversible'
                );
                
                console.log('Confirmation result:', confirmed);
                
                if (confirmed) {
                    if (productCard) {
                        productCard.style.transition = 'all 0.3s ease';
                        productCard.style.transform = 'translateX(-100%)';
                        productCard.style.opacity = '0';
                    }
                    
                    setTimeout(() => {
                        console.log('Submitting form...');
                        this.closest('form').submit();
                    }, 300);
                }
            });
        });

        window.showConfirmModal = function(title, message, subtitle) {
            return new Promise((resolve) => {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 animate-fadeIn';
                modal.innerHTML = `
                    <div class="bg-white rounded-xl p-6 max-w-md mx-4 transform transition-all duration-300 scale-95 animate-slideUp">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">${title}</h3>
                                <p class="text-sm text-gray-600">${subtitle}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">${message}</p>
                        <div class="flex space-x-3">
                            <button onclick="closeModal(false)" 
                                    class="flex-1 bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                Annuler
                            </button>
                            <button onclick="closeModal(true)" 
                                    class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium">
                                Supprimer
                            </button>
                        </div>
                    </div>
                `;
                
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                    @keyframes slideUp {
                        from { transform: translateY(20px) scale(0.95); opacity: 0; }
                        to { transform: translateY(0) scale(1); opacity: 1; }
                    }
                    .animate-fadeIn { animation: fadeIn 0.2s ease-out; }
                    .animate-slideUp { animation: slideUp 0.3s ease-out; }
                `;
                document.head.appendChild(style);
                
                window.closeModal = function(confirmed) {
                    modal.style.animation = 'fadeIn 0.2s ease-out reverse';
                    setTimeout(() => {
                        if (document.body.contains(modal)) {
                            document.body.removeChild(modal);
                        }
                        if (document.head.contains(style)) {
                            document.head.removeChild(style);
                        }
                        delete window.closeModal;
                        resolve(confirmed);
                    }, 200);
                };
                
                document.body.appendChild(modal);
                
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        window.closeModal(false);
                    }
                });
                
                setTimeout(() => {
                    const modalContent = modal.querySelector('.bg-white');
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }, 50);
            });
        };

        const cartItems = document.querySelectorAll('.bg-white.rounded-xl.shadow-md');
        cartItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });

        const savedCart = localStorage.getItem('cart_draft');
        if (savedCart) {
            const cartData = JSON.parse(savedCart);
            const timeDiff = Date.now() - cartData.timestamp;
            
            if (timeDiff < 300000) {
                console.log('Données de panier récentes trouvées');
            } else {
                localStorage.removeItem('cart_draft');
            }
        }
        
        if (navigator.onLine) {
            console.log('✅ Connexion internet disponible');
        } else {
            console.log('❌ Pas de connexion internet');
            showToast('Mode hors ligne détecté', 'info');
        }
        
        window.testUpdateTotals = function() {
            console.log('🧪 Testing cart totals update...');
            const testCart = {
                items_count: 3,
                subtotal: 450.00,
                shipping_amount: 25,
                tax_amount: 22.50,
                total_amount: 497.50
            };
            updateCartTotals(testCart);
            updateShippingIndicator(testCart.subtotal);
        };
        
        window.testEstimatedTotals = function() {
            console.log('🔧 Testing estimated totals calculation...');
            updateEstimatedTotals();
        };
        
        window.debugCartElements = function() {
            console.log('📊 DEBUG: All cart elements');
            console.log('Subtotal elements:', Array.from(document.querySelectorAll('[data-subtotal]')).map(el => ({element: el, text: el.textContent})));
            console.log('Total elements:', Array.from(document.querySelectorAll('[data-total]')).map(el => ({element: el, text: el.textContent})));
            console.log('Total-main elements:', Array.from(document.querySelectorAll('[data-total-main]')).map(el => ({element: el, text: el.textContent})));
            console.log('Items-count elements:', Array.from(document.querySelectorAll('[data-items-count]')).map(el => ({element: el, text: el.textContent})));
            console.log('Items-count-summary elements:', Array.from(document.querySelectorAll('[data-items-count-summary]')).map(el => ({element: el, text: el.textContent})));
        };
        
        window.debugQuantities = function() {
            console.log('🔍 DEBUG: Quantity inputs state');
            const inputs = document.querySelectorAll('input[type="number"][onchange*="updateQuantity"]');
            inputs.forEach((input, index) => {
                const onchangeAttr = input.getAttribute('onchange');
                const itemIdMatch = onchangeAttr.match(/updateQuantity\('([^']+)'/);
                if (itemIdMatch) {
                    const itemId = itemIdMatch[1];
                    const inputValue = parseInt(input.value);
                    const unitElement = document.querySelector(`[data-item-unit-${itemId}]`);
                    const unitText = unitElement ? unitElement.textContent : 'N/A';
                    const quantityInUnit = unitText.match(/× (\d+)/)?.[1];
                    
                    console.log(`Input ${index} (${itemId}):`, {
                        inputValue: inputValue,
                        unitText: unitText,
                        quantityFromUnit: quantityInUnit,
                        consistent: inputValue == quantityInUnit
                    });
                }
            });
        };
        
        console.log('🔧 Debug functions available: testUpdateTotals(), testEstimatedTotals(), debugCartElements(), debugQuantities()');
    });


    function showErrorMessage(message) {
        console.error('❌ Error:', message);
        
        let errorElement = document.querySelector('[data-cart-error]');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.setAttribute('data-cart-error', '');
            errorElement.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-in slide-in-from-right duration-300';
            document.body.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        
        setTimeout(() => {
            errorElement.style.display = 'none';
        }, 5000);
    }

    function showSuccessMessage(message) {
        console.log('✅ Success:', message);
        
        let successElement = document.querySelector('[data-cart-success]');
        if (!successElement) {
            successElement = document.createElement('div');
            successElement.setAttribute('data-cart-success', '');
            successElement.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-in slide-in-from-right duration-300';
            document.body.appendChild(successElement);
        }
        
        successElement.textContent = message;
        successElement.style.display = 'block';
        
        setTimeout(() => {
            successElement.style.display = 'none';
        }, 3000);
    }

    function setButtonLoadingState(button, isLoading) {
        if (!button) return;
        
        if (isLoading) {
            button.disabled = true;
            button.classList.add('opacity-50', 'cursor-not-allowed');
            const originalText = button.innerHTML;
            button.setAttribute('data-original-text', originalText);
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Traitement...
            `;
        } else {
            button.disabled = false;
            button.classList.remove('opacity-50', 'cursor-not-allowed');
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.innerHTML = originalText;
                button.removeAttribute('data-original-text');
            }
        }
    }

    function showSuccessAnimation(element) {
        if (element) {
            element.classList.add('animate-pulse', 'text-emerald-600', 'scale-105');
            setTimeout(() => {
                element.classList.remove('animate-pulse', 'text-emerald-600', 'scale-105');
            }, 1000);
        }
    }

    function checkUserAuthentication() {
        const authElements = document.querySelectorAll('[data-user-authenticated]');
        const loginRequiredElements = document.querySelectorAll('[data-login-required]');
        
        return authElements.length > 0 || loginRequiredElements.length === 0;
    }

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            const checkoutButton = document.querySelector('a[href*="checkout"]');
            if (checkoutButton) {
                checkoutButton.click();
            }
        }
    });
</script>
@endpush
@endsection
