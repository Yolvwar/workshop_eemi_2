@extends('layouts.shop')

@section('title', 'Mes Commandes - Boutique APWAP')
@section('page-title', 'Mes Commandes')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900"><x-heroicon-o-shopping-bag class="w-8 h-8 inline mr-3" /> Mes Commandes</h1>
            <p class="text-gray-600 mt-2">Suivez l'état de vos commandes et accédez à votre historique</p>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-2 mb-4 sm:mb-0">
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                        Toutes
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'pending' ? 'bg-orange-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                        En attente
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                        Confirmées
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'shipped' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                        Expédiées
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                        Livrées
                    </a>
                </div>
                
                <div class="flex items-center space-x-2">
                    <select onchange="window.location.href=this.value" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="{{ route('orders.index') }}">Trier par date</option>
                        <option value="{{ route('orders.index', ['sort' => 'amount_desc']) }}" {{ request('sort') === 'amount_desc' ? 'selected' : '' }}>Montant décroissant</option>
                        <option value="{{ route('orders.index', ['sort' => 'amount_asc']) }}" {{ request('sort') === 'amount_asc' ? 'selected' : '' }}>Montant croissant</option>
                    </select>
                </div>
            </div>
        </div>

        @if($orders->count() > 0)

        <!-- Liste des commandes -->
        <div class="space-y-6">
    @foreach($orders as $order)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- En-tête de commande -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h3 class="text-lg font-semibold text-gray-900">Commande #{{ $order->order_number }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
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
                        
                        <div class="flex items-center space-x-4">
                            <!-- Statut -->
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
                            
                            <!-- Montant total -->
                            <span class="text-lg font-bold text-gray-900">{{ $order->total_amount }} AED</span>
                        </div>
                    </div>
                </div>

                <!-- Contenu de la commande -->
                <div class="p-6">
                    <!-- Articles -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-4">Articles commandés ({{ $order->items->count() }})</h4>
                        <div class="space-y-3">
                            @foreach($order->items->take(3) as $item)
                            <div class="flex items-center space-x-4">
                                @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <x-heroicon-o-cube class="w-6 h-6 text-gray-400" />
                                </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-medium text-gray-900">{{ $item->product_name }}</h5>
                                    <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                                    @if($item->pet)
                                    <p class="text-xs text-emerald-600"><x-heroicon-o-heart class="w-3 h-3 inline mr-1" /> Pour: {{ $item->pet->name }}</p>
                                    @endif
                                </div>
                                
                                <div class="text-right">
                                    <span class="font-medium text-gray-900">{{ $item->total_price }} AED</span>
                                    <p class="text-sm text-gray-600">{{ $item->unit_price }} AED × {{ $item->quantity }}</p>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->items->count() > 3)
                            <div class="text-center py-2">
                                <button onclick="toggleOrderItems('{{ $order->id }}')" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                    Voir {{ $order->items->count() - 3 }} article(s) de plus
                                </button>
                            </div>
                            
                            <div id="order-items-{{ $order->id }}" class="hidden space-y-3">
                                @foreach($order->items->skip(3) as $item)
                                <div class="flex items-center space-x-4">
                                    @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ $item->product->images[0] }}" alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                        <x-heroicon-o-cube class="w-6 h-6 text-gray-400" />
                                    </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-medium text-gray-900">{{ $item->product_name }}</h5>
                                        <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                                        @if($item->pet)
                                        <p class="text-xs text-emerald-600"><x-heroicon-o-heart class="w-3 h-3 inline mr-1" /> Pour: {{ $item->pet->name }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="text-right">
                                        <span class="font-medium text-gray-900">{{ $item->total_price }} AED</span>
                                        <p class="text-sm text-gray-600">{{ $item->unit_price }} AED × {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informations de livraison -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h5 class="font-medium text-gray-900 mb-2"><x-heroicon-o-truck class="w-4 h-4 inline mr-2" /> Livraison</h5>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                                <p>{{ $order->shipping_address_line_1 }}</p>
                                @if($order->shipping_address_line_2)
                                <p>{{ $order->shipping_address_line_2 }}</p>
                                @endif
                                <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                @if($order->shipping_phone)
                                <p><x-heroicon-o-phone class="w-4 h-4 inline mr-1" /> {{ $order->shipping_phone }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h5 class="font-medium text-gray-900 mb-2"><x-heroicon-o-credit-card class="w-4 h-4 inline mr-2" /> Paiement</h5>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>Méthode: {{ ucfirst($order->payment_method) }}</p>
                                <p>Statut: 
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
                                </p>
                                @if($order->payment_reference)
                                <p>Référence: {{ $order->payment_reference }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('orders.show', $order) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                            <x-heroicon-o-eye class="w-4 h-4 inline mr-2" /> Voir détails
                        </a>
                        
                        @if($order->status === 'shipped' || $order->status === 'delivered')
                        <a href="{{ route('orders.track', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <x-heroicon-o-map-pin class="w-4 h-4 inline mr-2" /> Suivre
                        </a>
                        @endif
                        
                        @if($order->status === 'delivered')
                        <a href="{{ route('orders.download-invoice', $order) }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors">
                            <x-heroicon-o-document-text class="w-4 h-4 inline mr-2" /> Facture
                        </a>
                        @endif
                        
                        @if($order->status === 'delivered')
                        <form action="{{ route('orders.reorder', $order) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                                <x-heroicon-o-arrow-path class="w-4 h-4 inline mr-2" /> Recommander
                            </button>
                        </form>
                        @endif
                        
                        @if(in_array($order->status, ['pending', 'confirmed']) && $order->placed_at->diffInHours(now()) < 2)
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                <x-heroicon-o-x-circle class="w-4 h-4 inline mr-2" /> Annuler
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        <!-- État vide -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="text-6xl mb-6">
                    <x-heroicon-o-shopping-bag class="w-24 h-24 mx-auto text-gray-400" />
                </div>
                
                @if(request('status'))
                <!-- Message pour filtres appliqués -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucune commande trouvée</h2>
                <p class="text-gray-600 mb-8">
                    Aucune commande avec le statut "{{ 
                        request('status') === 'pending' ? 'En attente' : 
                        (request('status') === 'confirmed' ? 'Confirmée' : 
                        (request('status') === 'shipped' ? 'Expédiée' : 
                        (request('status') === 'delivered' ? 'Livrée' : 
                        ucfirst(request('status'))))) 
                    }}" n'a été trouvée.
                </p>
                
                <div class="space-y-3">
                    <a href="{{ route('orders.index') }}" class="block bg-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-emerald-700 transition-colors">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4 inline mr-2" /> Voir toutes les commandes
                    </a>
                    
                    <a href="{{ route('shop.index') }}" class="block bg-white text-emerald-600 px-8 py-3 rounded-full font-semibold border-2 border-emerald-600 hover:bg-emerald-50 transition-colors">
                        <x-heroicon-o-shopping-bag class="w-4 h-4 inline mr-2" /> Continuer mes achats
                    </a>
                </div>
                @else
                <!-- Message pour aucune commande -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucune commande</h2>
                <p class="text-gray-600 mb-8">Vous n'avez pas encore passé de commande. Découvrez nos produits premium pour vos compagnons.</p>
                
                <div class="space-y-3">
                    <a href="{{ route('shop.index') }}" class="block bg-emerald-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-emerald-700 transition-colors">
                        <x-heroicon-o-shopping-bag class="w-4 h-4 inline mr-2" /> Découvrir la boutique
                    </a>
                    
                    @if(auth()->user()->pets->count() > 0)
                    <a href="{{ route('shop.pet.recommendations', auth()->user()->pets->first()) }}" class="block bg-white text-emerald-600 px-8 py-3 rounded-full font-semibold border-2 border-emerald-600 hover:bg-emerald-50 transition-colors">
                        <x-heroicon-o-sparkles class="w-4 h-4 inline mr-2" /> Voir les recommandations
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function toggleOrderItems(orderId) {
        const element = document.getElementById('order-items-' + orderId);
        const button = event.target;
        
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            button.textContent = 'Masquer les articles';
        } else {
            element.classList.add('hidden');
            const hiddenCount = element.children.length;
            button.textContent = `Voir ${hiddenCount} article(s) de plus`;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const pendingOrders = document.querySelectorAll('[data-status="pending"], [data-status="confirmed"], [data-status="shipped"]');
        
        if (pendingOrders.length > 0) {
            setTimeout(() => {
                window.location.reload();
            }, 120000);
        }
    });
</script>
@endpush
@endsection
