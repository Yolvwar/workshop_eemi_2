@extends('layouts.shop')

@section('title', 'Boutique APWAP - Premium Pet Care & Wellness')
@section('page-title', 'Accueil')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Hero Banner Section -->
    <section class="relative overflow-hidden">
        <!-- Hero Image -->
        <div class="h-[600px] lg:h-[700px] relative">
            <img src="{{ asset('images/hero_image.jpg') }}" alt="APWAP - Premium Pet Care" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>
        
        <!-- Hero Content Overlay -->
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-2xl">
                    <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        Le Bien-être de Votre Animal, 
                        <span class="text-emerald-400">Notre Priorité</span>
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        Découvrez notre gamme premium de produits pour animaux. Livraison gratuite à Dubai pour les commandes de plus de 500 AED.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#featured-products" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl text-center">
                            <x-heroicon-o-shopping-bag class="w-6 h-6 inline mr-2" />
                            Découvrir la Boutique
                        </a>
                        <a href="/consultation" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 border border-white/30 text-center">
                            <x-heroicon-o-heart class="w-6 h-6 inline mr-2" />
                            Consultation Gratuite
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-200 transition-colors">
                        <x-heroicon-o-truck class="w-8 h-8 text-emerald-600" />
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Livraison Gratuite</h3>
                    <p class="text-gray-600 text-sm">Commandes >500 AED à Dubai</p>
                </div>
                <div class="text-center group">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                        <x-heroicon-o-shield-check class="w-8 h-8 text-blue-600" />
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Qualité Garantie</h3>
                    <p class="text-gray-600 text-sm">Produits certifiés premium</p>
                </div>
                <div class="text-center group">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                        <x-heroicon-o-clock class="w-8 h-8 text-purple-600" />
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Livraison Express</h3>
                    <p class="text-gray-600 text-sm">Sous 24h à Dubai</p>
                </div>
                <div class="text-center group">
                    <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-amber-200 transition-colors">
                        <x-heroicon-o-star class="w-8 h-8 text-amber-600" />
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Support Expert</h3>
                    <p class="text-gray-600 text-sm">Conseils vétérinaires inclus</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products avec Call-to-Action fort -->
    @if($featuredProducts->count() > 0)
    <section id="featured-products" class="py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mt-4 mb-4">
                    Produits les Plus Populaires
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Découvrez les produits préférés de nos clients à Dubai
                </p>
            </div>
            
            <!-- Products Slider -->
            <div class="products-slider-container relative">
                <!-- Navigation buttons -->
                <button class="products-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white shadow-lg hover:shadow-xl rounded-full flex items-center justify-center transition-all duration-300 group -ml-6">
                    <x-heroicon-o-chevron-left class="w-6 h-6 text-gray-600 group-hover:text-emerald-600 group-hover:scale-110 transition-all" />
                </button>
                <button class="products-next absolute right-0 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 bg-white shadow-lg hover:shadow-xl rounded-full flex items-center justify-center transition-all duration-300 group -mr-6">
                    <x-heroicon-o-chevron-right class="w-6 h-6 text-gray-600 group-hover:text-emerald-600 group-hover:scale-110 transition-all" />
                </button>
                
                <!-- Slider wrapper -->
                <div class="products-slider overflow-hidden">
                    <div class="products-track flex transition-transform duration-500 ease-in-out">
                        @foreach($featuredProducts as $product)
                        <div class="product-slide flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-4">
                            <a href="{{ route('shop.product', $product->slug) }}" class="block bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group overflow-hidden h-full">
                                @if($product->hasDiscount())
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                                @endif
                                
                                <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <x-heroicon-o-photo class="w-16 h-16" />
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-2">
                                            @if($product->hasDiscount())
                                                <span class="text-2xl font-bold text-emerald-600">{{ $product->price }} AED</span>
                                                <span class="text-lg text-gray-500 line-through">{{ $product->original_price }} AED</span>
                                            @else
                                                <span class="text-2xl font-bold text-gray-900">{{ $product->price }} AED</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <button onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})" 
                                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-6 rounded-xl font-semibold transition-colors">
                                        <x-heroicon-o-shopping-cart class="w-5 h-5 inline mr-2" />
                                        Ajouter au Panier
                                    </button>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Slider dots -->
                <div class="flex justify-center mt-8 space-x-2">
                    @php
                        $maxSlidesDesktop = ceil($featuredProducts->count() / 4);
                        $maxSlides = max(1, $maxSlidesDesktop);
                    @endphp
                    @for($i = 0; $i < $maxSlides; $i++)
                    <button class="products-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-emerald-500 transition-colors {{ $i === 0 ? 'bg-emerald-600' : '' }}" data-slide="{{ $i }}"></button>
                    @endfor
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="/products" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 transform hover:scale-105">
                    Voir Tous les Produits
                    <x-heroicon-o-arrow-right class="w-6 h-6 ml-2" />
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Categories avec design moderne -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Explorez par Catégorie
                </h2>
                <p class="text-xl text-gray-600">
                    Trouvez exactement ce dont votre animal a besoin
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $categoryIcons = [
                        'Nutrition & Alimentation' => 'cake',
                        'Santé & Hygiène' => 'heart',
                        'Jouets & Accessoires' => 'puzzle-piece',
                        'Confort & Lifestyle' => 'home',
                        'Éducation & Dressage' => 'academic-cap',
                        'Toilettage & Beauté' => 'sparkles'
                    ];
                    $mainCategories = $categories->where('parent_id', null)->take(8);
                @endphp
                
                @foreach($mainCategories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="group bg-gradient-to-br from-gray-50 to-gray-100 hover:from-emerald-50 hover:to-emerald-100 rounded-2xl p-6 text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-600 transition-colors shadow-sm">
                        @php
                            $iconName = $categoryIcons[$category->name] ?? 'squares-2x2';
                        @endphp
                        <x-dynamic-component :component="'heroicon-o-' . $iconName" class="w-8 h-8 text-gray-600 group-hover:text-white" />
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                        {{ $category->name }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $category->description }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Social Proof et Témoignages -->
    <section class="py-16 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Nos Clients Nous Font Confiance
                </h2>
                <p class="text-xl text-gray-600">
                    Rejoignez plus de 10,000 familles heureuses à Dubai
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-2xl p-8 shadow-lg text-center">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">10,000+</div>
                    <div class="text-gray-600">Clients Satisfaits</div>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg text-center">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">4.9/5</div>
                    <div class="text-gray-600">Note Moyenne</div>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-lg text-center">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">24h</div>
                    <div class="text-gray-600">Livraison Express</div>
                </div>
            </div>
            
            <!-- Témoignages -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Service exceptionnel ! Mon chat adore ses nouveaux jouets et la livraison était très rapide."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-emerald-600 font-semibold">SA</span>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Sarah Al-Mansouri</div>
                            <div class="text-sm text-gray-600">Dubai Marina</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Qualité premium et conseils d'experts. Je recommande vivement APWAP à tous les propriétaires d'animaux."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-emerald-600 font-semibold">MK</span>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Mohammed Khalil</div>
                            <div class="text-sm text-gray-600">Downtown Dubai</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                            <x-heroicon-s-star class="w-5 h-5" />
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"Les produits sont de très haute qualité et l'équipe APWAP est toujours disponible pour nous aider."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-emerald-600 font-semibold">EJ</span>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Emma Johnson</div>
                            <div class="text-sm text-gray-600">Jumeirah</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Final -->
    <section class="py-16 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Prêt à Offrir le Meilleur à Votre Animal ?
            </h2>
            <p class="text-xl mb-8 opacity-90">
                Rejoignez notre communauté et bénéficiez d'offres exclusives, de conseils d'experts et d'une livraison gratuite.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/products" class="bg-white text-emerald-600 hover:bg-gray-100 px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 transform hover:scale-105">
                    <x-heroicon-o-shopping-bag class="w-6 h-6 inline mr-2" />
                    Commencer mes Achats
                </a>
                <a href="/consultation" class="bg-emerald-800 hover:bg-emerald-900 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 border border-emerald-500">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 inline mr-2" />
                    Consultation Gratuite
                </a>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<style>
/* Products Slider Styles */
.products-slider-container {
    position: relative;
}

.products-slider {
    overflow: hidden;
    margin: 0 40px;
}

.products-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.product-slide {
    min-width: 0;
}

.product-slide a {
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.product-slide a:hover {
    text-decoration: none;
}

.products-dot.active,
.products-dot.bg-emerald-600 {
    background-color: #059669 !important;
    transform: scale(1.2);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .products-slider {
        margin: 0 20px;
    }
    
    .products-prev,
    .products-next {
        width: 40px;
        height: 40px;
        margin: 0 -20px;
    }
    
    .product-slide {
        width: 100%;
        padding: 0 8px;
    }
}

@media (min-width: 640px) and (max-width: 767px) {
    .product-slide {
        width: 50%;
        padding: 0 8px;
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .product-slide {
        width: 33.333%;
        padding: 0 8px;
    }
}

@media (min-width: 1024px) {
    .product-slide {
        width: 25%;
        padding: 0 8px;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `opacity 0.8s ease-out ${index * 0.1}s, transform 0.8s ease-out ${index * 0.1}s`;
            observer.observe(el);
        });
    });

    function addToCart(productId) {
        event.target.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Ajout en cours...';
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            event.target.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"></path></svg>Ajouté !';
            event.target.classList.add('bg-green-600');
            
            showNotification('Produit ajouté au panier !', 'success');
            
            setTimeout(() => {
                event.target.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"></path></svg>Ajouter au Panier';
                event.target.classList.remove('bg-green-600');
            }, 2000);
        })
        .catch(error => {
            console.error('Erreur:', error);
            event.target.innerHTML = 'Erreur';
            setTimeout(() => {
                event.target.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"></path></svg>Ajouter au Panier';
            }, 2000);
        });
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(full)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const productsSlider = document.querySelector('.products-slider');
        if (!productsSlider) return;
        
        const track = document.querySelector('.products-track');
        const slides = document.querySelectorAll('.product-slide');
        const prevBtn = document.querySelector('.products-prev');
        const nextBtn = document.querySelector('.products-next');
        const dots = document.querySelectorAll('.products-dot');
        
        let currentSlide = 0;
        let slidesPerView = 4;
        let isAnimating = false;
        
        function updateSlidesPerView() {
            if (window.innerWidth < 640) {
                slidesPerView = 1;
            } else if (window.innerWidth < 768) {
                slidesPerView = 2;
            } else if (window.innerWidth < 1024) {
                slidesPerView = 3;
            } else {
                slidesPerView = 4;
            }
        }
        
        function updateSlidePosition() {
            const slideWidth = 100 / slidesPerView;
            track.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
                dot.classList.toggle('bg-emerald-600', index === currentSlide);
            });
        }
        
        function nextSlide() {
            if (isAnimating) return;
            isAnimating = true;
            
            const maxSlides = Math.max(0, Math.ceil(slides.length / slidesPerView) - 1);
            currentSlide = currentSlide >= maxSlides ? 0 : currentSlide + 1;
            updateSlidePosition();
            
            setTimeout(() => {
                isAnimating = false;
            }, 500);
        }
        
        function prevSlide() {
            if (isAnimating) return;
            isAnimating = true;
            
            const maxSlides = Math.max(0, Math.ceil(slides.length / slidesPerView) - 1);
            currentSlide = currentSlide <= 0 ? maxSlides : currentSlide - 1;
            updateSlidePosition();
            
            setTimeout(() => {
                isAnimating = false;
            }, 500);
        }
        
        function goToSlide(index) {
            if (isAnimating) return;
            isAnimating = true;
            
            currentSlide = index;
            updateSlidePosition();
            
            setTimeout(() => {
                isAnimating = false;
            }, 500);
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', nextSlide);
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', prevSlide);
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });
        
        window.addEventListener('resize', () => {
            updateSlidesPerView();
            updateSlidePosition();
        });
        
        let startX = 0;
        let endX = 0;
        
        productsSlider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        productsSlider.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            const swipeThreshold = 50;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        });
        
        let autoplayInterval = setInterval(nextSlide, 4000);
        
        productsSlider.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });
        
        productsSlider.addEventListener('mouseleave', () => {
            autoplayInterval = setInterval(nextSlide, 4000);
        });
        
        updateSlidesPerView();
        updateSlidePosition();
    });
</script>
@endpush
@endsection
