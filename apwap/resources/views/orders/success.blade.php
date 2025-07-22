@extends('layouts.shop')

@section('title', 'Commande Confirmée ✨ - APWAP Boutique')

@section('content')
<!-- 🎉 Bannière de succès harmonisée avec le design boutique -->
<div class="bg-gradient-to-r from-emerald-500 via-emerald-600 to-green-600 text-white relative overflow-hidden">
    <!-- Pattern de fond subtil -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#grid)" />
        </svg>
    </div>
    
    <!-- Particules animées -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-10 left-[10%] w-2 h-2 bg-yellow-300 rounded-full animate-ping"></div>
        <div class="absolute top-20 right-[15%] w-3 h-3 bg-white/30 rounded-full animate-bounce"></div>
        <div class="absolute bottom-16 left-[25%] w-2 h-2 bg-emerald-200 rounded-full animate-pulse"></div>
        <div class="absolute top-32 left-[70%] w-4 h-4 bg-green-200/40 rounded-full animate-bounce delay-300"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <!-- Icône de succès -->
        <div class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full backdrop-blur-sm border border-white/30">
            <x-heroicon-o-check class="w-10 h-10 text-white" />
        </div>
        
        <h1 class="text-3xl md:text-4xl font-bold mb-4">
            Commande Confirmée avec Succès !
        </h1>
        
        <p class="text-lg md:text-xl mb-3 opacity-95">
            Merci <strong>{{ auth()->user()->name }}</strong> pour votre confiance
        </p>
        
        <p class="text-base opacity-90 max-w-2xl mx-auto">
            Votre commande <span class="font-mono bg-white/20 px-2 py-1 rounded font-semibold">#{{ $order->order_number }}</span> 
            a été traitée et confirmée. Un email de confirmation vous a été envoyé.
        </p>
    </div>
</div>

<!-- 📋 Contenu principal en 2 colonnes -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- 🔍 COLONNE GAUCHE - Détails de la commande (2/3 de l'espace) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- 📊 Résumé de commande principal -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- En-tête de la commande -->
                <div class="bg-gray-50 px-6 py-5 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Détails de votre commande</h2>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1.5">
                                    <x-heroicon-o-document-text class="w-4 h-4 text-emerald-500" />
                                    N° {{ $order->order_number }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <x-heroicon-o-clock class="w-4 h-4 text-blue-500" />
                                    {{ $order->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Badge statut et montant -->
                        <div class="flex flex-col lg:items-end gap-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                <x-heroicon-o-check-circle class="w-4 h-4 mr-1.5" />
                                {{ ucfirst($order->status) }}
                            </span>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900">{{ $order->total_amount }} AED</div>
                                <div class="text-sm text-gray-500">{{ $order->items->sum('quantity') }} article{{ $order->items->sum('quantity') > 1 ? 's' : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline de progression -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                        <x-heroicon-o-clock class="w-5 h-5 text-emerald-500" />
                        Progression de votre commande
                    </h3>
                    
                    <div class="relative">
                        <!-- Ligne de progression -->
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-500 via-blue-500 to-gray-300"></div>
                        
                        <div class="space-y-8">
                            <!-- Étape 1: Confirmée ✅ -->
                            <div class="relative flex items-start gap-4">
                                <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                                    <x-heroicon-o-check class="w-6 h-6 text-white" />
                                </div>
                                <div class="pt-1">
                                    <div class="font-semibold text-gray-900">Commande confirmée</div>
                                    <div class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                                    <div class="text-sm text-emerald-600 mt-1">✅ Paiement validé et commande enregistrée</div>
                                </div>
                            </div>
                            
                            <!-- Étape 2: En préparation 🔄 -->
                            <div class="relative flex items-start gap-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center relative z-10 shadow-lg">
                                    <x-heroicon-o-cube class="w-6 h-6 text-white" />
                                </div>
                                <div class="pt-1">
                                    <div class="font-semibold text-gray-900">En cours de préparation</div>
                                    <div class="text-sm text-gray-600">Notre équipe prépare vos articles avec soin</div>
                                    <div class="text-sm text-blue-600 mt-1">🔄 Étape actuelle</div>
                                </div>
                            </div>
                            
                            <!-- Étape 3: Expédition ⏳ -->
                            <div class="relative flex items-start gap-4 opacity-60">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center relative z-10">
                                    <x-heroicon-o-truck class="w-6 h-6 text-gray-600" />
                                </div>
                                <div class="pt-1">
                                    <div class="font-semibold text-gray-600">Expédition</div>
                                    <div class="text-sm text-gray-500">Prochaine étape</div>
                                    <div class="text-sm text-gray-400 mt-1">⏳ Bientôt disponible</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles commandés -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                        <x-heroicon-o-shopping-bag class="w-5 h-5 text-blue-500" />
                        Articles commandés ({{ $order->items->count() }})
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                            <!-- Image du produit -->
                            <div class="w-16 h-16 bg-white rounded-lg shadow-sm flex items-center justify-center overflow-hidden border border-gray-100">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center w-full h-full bg-gradient-to-br from-emerald-50 to-blue-50">
                                        <x-heroicon-o-cube class="w-8 h-8 text-emerald-400" />
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Détails du produit -->
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-600 mb-1">{{ $item->product->category->name ?? 'Produit' }}</p>
                                @if($item->pet)
                                    <p class="text-sm text-emerald-600 font-medium">
                                        <x-heroicon-o-heart class="w-4 h-4 inline mr-1" />
                                        Pour {{ $item->pet->name }}
                                    </p>
                                @endif
                            </div>
                            
                            <!-- Prix et quantité -->
                            <div class="text-right">
                                <div class="font-semibold text-gray-900 text-lg">{{ $item->unit_price }} AED</div>
                                <div class="text-sm text-gray-600">Qté: {{ $item->quantity }}</div>
                                <div class="text-sm font-semibold text-emerald-600 mt-1">
                                    Total: {{ $item->total_price }} AED
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- � Boutons d'action principaux -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <x-heroicon-o-bolt class="w-5 h-5 text-emerald-500" />
                    Actions rapides
                </h3>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    <!-- Voir les détails -->
                    <a href="{{ route('orders.show', $order) }}" 
                       class="flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 hover:shadow-xl transition-all duration-300 group">
                        <x-heroicon-o-eye class="w-5 h-5 group-hover:scale-110 transition-transform" />
                        <span>Voir les détails</span>
                    </a>
                    
                    <!-- Suivre la commande -->
                    <a href="{{ route('orders.track', $order) }}" 
                       class="flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-emerald-700 hover:to-emerald-800 hover:shadow-xl transition-all duration-300 group">
                        <x-heroicon-o-map-pin class="w-5 h-5 group-hover:scale-110 transition-transform" />
                        <span>Suivre ma commande</span>
                    </a>
                </div>
                
                <!-- Continuer les achats - Bouton plus large -->
                <a href="{{ route('shop.index') }}" 
                   class="mt-4 w-full flex items-center justify-center gap-3 bg-white text-gray-700 font-semibold py-4 px-6 rounded-xl shadow-lg border-2 border-gray-200 hover:bg-gray-50 hover:border-emerald-300 hover:text-emerald-700 transition-all duration-300 group">
                    <x-heroicon-o-shopping-bag class="w-5 h-5 group-hover:scale-110 transition-transform" />
                    <span>Continuer mes achats</span>
                </a>
            </div>
        </div>

        <!-- 💰 COLONNE DROITE - Résumé et informations (1/3 de l'espace) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Récapitulatif des montants -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <x-heroicon-o-calculator class="w-5 h-5 text-emerald-500" />
                    Récapitulatif
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="font-medium text-gray-900">{{ $order->subtotal_amount }} AED</span>
                    </div>
                    
                    @if($order->shipping_amount > 0)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Frais de livraison</span>
                        <span class="font-medium text-gray-900">{{ $order->shipping_amount }} AED</span>
                    </div>
                    @else
                    <div class="flex justify-between items-center py-2">
                        <span class="text-emerald-600 flex items-center gap-1">
                            <x-heroicon-o-truck class="w-4 h-4" />
                            Livraison gratuite
                        </span>
                        <span class="font-medium text-emerald-600">0 AED</span>
                    </div>
                    @endif
                    
                    @if($order->tax_amount > 0)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">TVA (5%)</span>
                        <span class="font-medium text-gray-900">{{ $order->tax_amount }} AED</span>
                    </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-emerald-600">{{ $order->total_amount }} AED</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de livraison -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <x-heroicon-o-map-pin class="w-5 h-5 text-blue-500" />
                    Livraison
                </h3>
                
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Adresse:</span>
                        <p class="text-sm text-gray-600 mt-1">{{ $order->shipping_address }}</p>
                    </div>
                    
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-700 flex items-start gap-2">
                            <x-heroicon-o-information-circle class="w-4 h-4 mt-0.5 flex-shrink-0" />
                            Un email avec les détails de suivi vous sera envoyé dès l'expédition
                        </p>
                    </div>
                </div>
            </div>

            <!-- Centre d'aide -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <x-heroicon-o-question-mark-circle class="w-5 h-5 text-emerald-500" />
                    Besoin d'aide ?
                </h3>
                
                <p class="text-gray-600 mb-4 text-sm">Notre équipe support est disponible pour vous aider !</p>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <x-heroicon-o-envelope class="w-4 h-4 text-emerald-600" />
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 text-sm">Email</div>
                            <div class="text-xs text-gray-600">support@apwap.com</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <x-heroicon-o-phone class="w-4 h-4 text-blue-600" />
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 text-sm">Téléphone</div>
                            <div class="text-xs text-gray-600">+971 4 123 4567</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <x-heroicon-o-clock class="w-4 h-4 text-purple-600" />
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 text-sm">Horaires</div>
                            <div class="text-xs text-gray-600">Lun-Ven: 9h-18h</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations importantes -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500" />
                    Informations utiles
                </h3>
                
                <div class="space-y-4">
                    <div class="bg-emerald-50 p-3 rounded-lg border border-emerald-200">
                        <div class="flex items-start gap-2">
                            <x-heroicon-o-check-circle class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" />
                            <div>
                                <h4 class="font-medium text-emerald-900 mb-1 text-sm">Email envoyé</h4>
                                <p class="text-xs text-emerald-700">Récapitulatif détaillé dans votre boîte mail</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <div class="flex items-start gap-2">
                            <x-heroicon-o-truck class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" />
                            <div>
                                <h4 class="font-medium text-blue-900 mb-1 text-sm">Délai de livraison</h4>
                                <p class="text-xs text-blue-700">2-3 jours ouvrables à Dubaï</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                        <div class="flex items-start gap-2">
                            <x-heroicon-o-exclamation-triangle class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" />
                            <div>
                                <h4 class="font-medium text-yellow-900 mb-1 text-sm">Retour gratuit</h4>
                                <p class="text-xs text-yellow-700">Sous 30 jours si non satisfait</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Animations personnalisées pour la page de succès */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes sparkle {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-sparkle {
    animation: sparkle 2s ease-in-out infinite;
}

/* Effet de particules subtil */
.success-particles::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120, 219, 226, 0.3) 0%, transparent 50%);
    pointer-events: none;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    elements.forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('opacity-100', 'transform', 'translate-y-0');
        }, index * 200);
    });
});
</script>
@endpush
@endsection
