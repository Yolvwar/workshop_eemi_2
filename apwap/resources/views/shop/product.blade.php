@extends('layouts.shop')

@section('title', $product->name . ' - Boutique APWAP')
@section('page-title', $product->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('shop.index') }}" class="ml-2 text-gray-500 hover:text-emerald-600 flex items-center gap-1">
                        Boutique
                    </a></li>
                    <li><x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" /></li>
                    <li><a href="{{ route('shop.category', $product->category->slug) }}" class="text-gray-500 hover:text-emerald-600">{{ $product->category->name }}</a></li>
                    <li><x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" /></li>
                    <li><span class="text-gray-900 font-medium">{{ Str::limit($product->name, 50) }}</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12">
            <!-- Galerie d'images -->
            <div class="mb-8 lg:mb-0">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Image principale -->
                    <div class="relative">
                        @if($product->images && count($product->images) > 0)
                        <img id="main-image" src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-96 lg:h-[500px] object-cover">
                        @else
                        <div class="w-full h-96 lg:h-[500px] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <x-heroicon-o-cube class="w-24 h-24 text-gray-400" />
                        </div>
                        @endif
                        
                        @if($product->original_price && $product->original_price > $product->price)
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}% OFF
                        </div>
                        @endif
                        
                        @if($product->featured)
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white p-2 rounded-full">
                            <x-heroicon-s-star class="w-5 h-5" />
                        </div>
                        @endif
                    </div>
                    
                    <!-- Miniatures -->
                    @if($product->images && count($product->images) > 1)
                    <div class="p-4">
                        <div class="flex space-x-2 overflow-x-auto">
                            @foreach($product->images as $index => $image)
                            <button onclick="changeMainImage('{{ $image }}', {{ $index }})" 
                                    class="thumbnail flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-emerald-500 transition-colors {{ $index === 0 ? 'border-emerald-500' : '' }}">
                                <img src="{{ $image }}" alt="Image {{ $index + 1 }}" class="w-full h-full object-cover">
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informations produit -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-sm text-emerald-600 font-medium bg-emerald-50 px-3 py-1 rounded-full">
                                {{ $product->category->name }}
                            </span>
                            @if($product->primary_pillar)
                            <span class="text-sm text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full">
                                {{ ucfirst($product->primary_pillar) }}
                            </span>
                            @endif
                            @if($product->brand)
                            <span class="text-sm text-gray-600 font-medium bg-gray-50 px-3 py-1 rounded-full">
                                {{ $product->brand }}
                            </span>
                            @endif
                        </div>
                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        <!-- Rating et avis -->
                        @if($product->rating > 0)
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                @if($i <= $product->rating)
                                    <x-heroicon-s-star class="w-5 h-5 text-yellow-400" />
                                @else
                                    <x-heroicon-o-star class="w-5 h-5 text-gray-300" />
                                @endif
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">{{ $product->rating }}/5</span>
                            </div>
                            <span class="text-sm text-gray-500">({{ $product->review_count }} avis)</span>
                            <a href="#reviews" class="text-sm text-emerald-600 hover:text-emerald-700">Voir les avis</a>
                        </div>
                        @endif
                        
                        <!-- Prix -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl font-bold text-gray-900">{{ $product->price }} AED</span>
                                @if($product->original_price && $product->original_price > $product->price)
                                <span class="text-xl text-gray-500 line-through">{{ $product->original_price }} AED</span>
                                <span class="text-sm text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full">
                                    Économie: {{ $product->original_price - $product->price }} AED
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description courte -->
                    @if($product->short_description)
                    <div class="mb-6">
                        <p class="text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                    </div>
                    @endif

                    <!-- Recommandations pour animaux -->
                    @if($pets && $pets->count() > 0)
                    <div class="mb-6 bg-emerald-50 rounded-xl p-4">
                        <h3 class="font-semibold text-emerald-800 mb-3 flex items-center gap-2">
                            Parfait pour vos animaux
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($pets as $pet)
                            <div class="bg-white rounded-lg p-3 flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ $pet->species === 'dog' ? '🐕' : ($pet->species === 'cat' ? '🐱' : '🐾') }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $pet->name }}</p>
                                    <p class="text-xs text-gray-600">{{ ucfirst($pet->breed) }}</p>
                                </div>
                                <div class="flex-1 text-right">
                                    <span class="text-xs text-emerald-600 font-medium">✅ Adapté</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Stock et disponibilité -->
                    <div class="mb-6">
                        @if($product->stock_quantity > 0)
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-orange-600" />
                                    <span class="text-orange-800 font-medium">Stock limité: {{ $product->stock_quantity }} restant(s)</span>
                                </div>
                            </div>
                            @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                                <div class="flex items-center gap-2">
                                    <x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />
                                    <span class="text-green-800 font-medium">En stock</span>
                                </div>
                            </div>
                            @endif
                        @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-x-circle class="w-5 h-5 text-red-600" />
                                <span class="text-red-800 font-medium">Rupture de stock</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Options d'achat -->
                    @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Quantité -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="changeQuantity(-1)" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                       class="w-20 text-center py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <button type="button" onclick="changeQuantity(1)" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">+</button>
                                <span class="text-sm text-gray-500">Max: {{ $product->stock_quantity }}</span>
                            </div>
                        </div>

                        <!-- Sélection d'animal (si connecté) -->
                        @if($pets && $pets->count() > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pour quel animal ? (optionnel)</label>
                            <select name="pet_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">Sélectionner un animal</option>
                                @foreach($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }} ({{ ucfirst($pet->species) }})</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Boutons d'action -->
                        <div class="space-y-3">
                            <button type="submit" class="w-full bg-emerald-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                                <x-heroicon-o-shopping-cart class="w-5 h-5" />
                                Ajouter au panier
                            </button>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" onclick="addToWishlist('{{ $product->id }}')" class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-heart class="w-4 h-4" />
                                    Favoris
                                </button>
                                <button type="button" onclick="shareProduct()" class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-share class="w-4 h-4" />
                                    Partager
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                    <!-- Informations de livraison -->
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <x-heroicon-o-truck class="w-5 h-5" />
                            Livraison & Options
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />
                                <span class="text-sm text-gray-700">Livraison standard: Demain (gratuite >500 AED)</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <x-heroicon-o-bolt class="w-5 h-5 text-blue-600" />
                                <span class="text-sm text-gray-700">Livraison express: 2h (+50 AED)</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <x-heroicon-o-arrow-path class="w-5 h-5 text-purple-600" />
                                <span class="text-sm text-gray-700">Abonnement mensuel: {{ round($product->price * 0.9) }} AED (-10%)</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <x-heroicon-o-gift class="w-5 h-5 text-yellow-600" />
                                <span class="text-sm text-gray-700">Emballage cadeau: +25 AED</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections supplémentaires -->
        <div class="mt-12 space-y-8">
            <!-- Description détaillée -->
            @if($product->description)
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    Description Détaillée
                </h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            @endif

            <!-- Spécifications -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    Spécifications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Informations générales</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Référence (SKU):</dt>
                                <dd class="font-medium">{{ $product->sku }}</dd>
                            </div>
                            @if($product->brand)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Marque:</dt>
                                <dd class="font-medium">{{ $product->brand }}</dd>
                            </div>
                            @endif
                            @if($product->weight)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Poids:</dt>
                                <dd class="font-medium">{{ $product->weight }}kg</dd>
                            </div>
                            @endif
                            @if($product->dimensions)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Dimensions:</dt>
                                <dd class="font-medium">{{ $product->dimensions }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Compatibilité</h3>
                        <dl class="space-y-3">
                            @if($product->suitable_for_species)
                            <div>
                                <dt class="text-gray-600 mb-1">Espèces:</dt>
                                <dd class="font-medium">{{ is_array($product->suitable_for_species) ? implode(', ', $product->suitable_for_species) : $product->suitable_for_species }}</dd>
                            </div>
                            @endif
                            @if($product->suitable_for_ages)
                            <div>
                                <dt class="text-gray-600 mb-1">Âges:</dt>
                                <dd class="font-medium">{{ is_array($product->suitable_for_ages) ? implode(', ', $product->suitable_for_ages) : $product->suitable_for_ages }}</dd>
                            </div>
                            @endif
                            @if($product->suitable_for_sizes)
                            <div>
                                <dt class="text-gray-600 mb-1">Tailles:</dt>
                                <dd class="font-medium">{{ is_array($product->suitable_for_sizes) ? implode(', ', $product->suitable_for_sizes) : $product->suitable_for_sizes }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Avis clients -->
            <div id="reviews" class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    Avis Clients
                </h2>
                
                @if($product->reviews && $product->reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($product->reviews->take(5) as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-b-0">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($review->user->first_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-medium text-gray-900">{{ $review->user->first_name }}</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <x-heroicon-s-star class="w-4 h-4 text-yellow-400" />
                                        @else
                                            <x-heroicon-o-star class="w-4 h-4 text-gray-300" />
                                        @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                @if($review->title)
                                <h4 class="font-medium text-gray-900 mb-2">{{ $review->title }}</h4>
                                @endif
                                <p class="text-gray-700">{{ $review->comment }}</p>
                                
                                @if($review->is_verified_purchase)
                                <span class="inline-block mt-2 text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full flex items-center gap-1 w-fit">
                                    <x-heroicon-o-check-badge class="w-3 h-3" />
                                    Achat vérifié
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($product->reviews->count() > 5)
                <div class="text-center mt-6">
                    <button class="bg-emerald-100 text-emerald-700 px-6 py-2 rounded-lg font-medium hover:bg-emerald-200 transition-colors">
                        Voir tous les avis ({{ $product->reviews->count() }})
                    </button>
                </div>
                @endif
                @else
                <div class="text-center py-8">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun avis pour le moment</h3>
                    <p class="text-gray-600">Soyez le premier à laisser un avis sur ce produit.</p>
                </div>
                @endif
            </div>

            <!-- Produits similaires -->
            @if($similarProducts && $similarProducts->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <x-heroicon-o-link class="w-6 h-6" />
                    Produits Similaires
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similarProducts as $relatedProduct)
                    <div class="group">
                        <a href="{{ route('shop.product', $relatedProduct->slug) }}" class="block">
                            <div class="bg-gray-50 rounded-xl overflow-hidden mb-3 group-hover:shadow-lg transition-shadow">
                                @if($relatedProduct->images && count($relatedProduct->images) > 0)
                                <img src="{{ $relatedProduct->images[0] }}" alt="{{ $relatedProduct->name }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                <div class="w-full h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <x-heroicon-o-cube class="w-12 h-12 text-gray-400" />
                                </div>
                                @endif
                            </div>
                            <h3 class="font-medium text-gray-900 mb-1 group-hover:text-emerald-600 transition-colors">{{ Str::limit($relatedProduct->name, 40) }}</h3>
                            <p class="text-emerald-600 font-semibold">{{ $relatedProduct->price }} AED</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeMainImage(imageUrl, index) {
        document.getElementById('main-image').src = imageUrl;
        
        document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('border-emerald-500');
                thumb.classList.remove('border-transparent');
            } else {
                thumb.classList.remove('border-emerald-500');
                thumb.classList.add('border-transparent');
            }
        });
    }

    function changeQuantity(delta) {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max);
        const minValue = parseInt(quantityInput.min);
        
        const newValue = currentValue + delta;
        
        if (newValue >= minValue && newValue <= maxValue) {
            quantityInput.value = newValue;
        }
    }

    function addToWishlist(productId) {
        console.log('Ajouter à la wishlist:', productId);
        
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = '✅ Ajouté';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.textContent = originalText;
            btn.disabled = false;
        }, 2000);
    }

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: '{{ $product->short_description }}',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Lien copié dans le presse-papiers !');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    });
</script>
@endpush
@endsection
