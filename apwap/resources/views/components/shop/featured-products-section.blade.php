@props(['featuredProducts'])

<div class="relative">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2">
                <x-heroicon-o-star class="w-8 h-8 text-yellow-500" />
                Produits Vedettes
            </h2>
            <p class="text-lg text-gray-600">Sélection premium pour vos compagnons</p>
        </div>
        
        <!-- Navigation Controls -->
        <div class="flex space-x-2">
            <button id="featured-prev" class="p-3 rounded-full bg-white shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors group">
                <x-heroicon-o-chevron-left class="w-5 h-5 text-gray-600 group-hover:text-emerald-600" />
            </button>
            <button id="featured-next" class="p-3 rounded-full bg-white shadow-lg border border-gray-200 hover:bg-gray-50 transition-colors group">
                <x-heroicon-o-chevron-right class="w-5 h-5 text-gray-600 group-hover:text-emerald-600" />
            </button>
        </div>
    </div>
    
    <!-- Slider Container -->
    <div class="relative overflow-hidden">
        <div id="featured-slider" class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0%)">
            @foreach($featuredProducts as $index => $product)
            <div class="flex-none w-full sm:w-1/2 lg:w-1/4 px-3">
                <div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 group flex flex-col h-full">
                    <!-- Image Section -->
                    <div class="relative flex-shrink-0">
                        @if($product->images && count($product->images) > 0)
                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <x-heroicon-o-cube class="w-10 h-10 text-gray-400" />
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
                                <x-heroicon-o-star class="w-3 h-3" />
                            </div>
                            @endif
                        </div>

                        <!-- Wishlist Button -->
                        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg hover:bg-white hover:scale-110 transition-all duration-200">
                                <x-heroicon-o-heart class="w-4 h-4 text-gray-600 hover:text-red-500" />
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="p-4 flex flex-col flex-grow">
                        <!-- Category -->
                        <div class="mb-2">
                            <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="font-bold text-gray-900 mb-2 text-sm group-hover:text-emerald-600 transition-colors leading-tight">
                            {{ Str::limit($product->name, 40) }}
                        </h3>
                        
                        <!-- Description -->
                        @if($product->short_description)
                        <p class="text-xs text-gray-600 mb-3 leading-relaxed">{{ Str::limit($product->short_description, 60) }}</p>
                        @endif
                        
                        <!-- Rating -->
                        @if($product->rating > 0)
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->rating))
                                    <x-heroicon-o-star class="w-3 h-3 text-yellow-400 fill-yellow-400" />
                                    @else
                                    <x-heroicon-o-star class="w-3 h-3 text-gray-300" />
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-600 ml-1">({{ $product->rating }})</span>
                        </div>
                        @endif
                        
                        <!-- Spacer pour pousser le prix et les boutons vers le bas -->
                        <div class="flex-grow"></div>
                        
                        <!-- Price Section -->
                        <div class="mb-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg font-bold text-gray-900">{{ $product->price }} AED</span>
                                    @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-xs text-gray-500 line-through">{{ $product->original_price }} AED</span>
                                    @endif
                                </div>
                                @if($product->original_price && $product->original_price > $product->price)
                                <span class="text-xs font-semibold text-green-600">
                                    -{{ $product->original_price - $product->price }} AED
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Buttons (Always at bottom) -->
                        <div class="flex gap-2 mt-auto">
                            <!-- Quick Add Button -->
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-2 px-3 rounded-lg text-xs font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-1">
                                    <x-heroicon-o-shopping-cart class="w-3 h-3" />
                                    Ajouter
                                </button>
                            </form>
                            
                            <!-- View Details Button -->
                            <a href="{{ route('shop.product', $product->slug) }}" class="flex-1 bg-white text-gray-700 py-2 px-3 rounded-lg text-center text-xs font-medium hover:bg-gray-50 transition-colors border border-gray-300 hover:border-gray-400">
                                Détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Pagination Dots -->
    <div class="flex justify-center mt-6 space-x-2">
        @for($i = 0; $i < ceil(count($featuredProducts) / 4); $i++)
        <button class="featured-dot w-2 h-2 rounded-full transition-colors duration-300 {{ $i === 0 ? 'bg-emerald-600' : 'bg-gray-300' }}" data-slide="{{ $i }}"></button>
        @endfor
    </div>
</div>

<!-- JavaScript pour le slider -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('featured-slider');
    const prevBtn = document.getElementById('featured-prev');
    const nextBtn = document.getElementById('featured-next');
    const dots = document.querySelectorAll('.featured-dot');
    
    let currentSlide = 0;
    const totalProducts = {{ count($featuredProducts) }};
    const slidesPerView = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1);
    const totalSlides = Math.ceil(totalProducts / slidesPerView);
    
    function updateSlider() {
        const translateX = -(currentSlide * (100 / slidesPerView));
        slider.style.transform = `translateX(${translateX}%)`;
        
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-emerald-600', index === currentSlide);
            dot.classList.toggle('bg-gray-300', index !== currentSlide);
        });
        
        prevBtn.style.opacity = currentSlide === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentSlide === totalSlides - 1 ? '0.5' : '1';
    }
    
    prevBtn.addEventListener('click', function() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    });
    
    nextBtn.addEventListener('click', function() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlider();
        }
    });
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            currentSlide = index;
            updateSlider();
        });
    });
    
    setInterval(function() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
        } else {
            currentSlide = 0;
        }
        updateSlider();
    }, 5000); 
    
    updateSlider();
    
    window.addEventListener('resize', function() {
        const newSlidesPerView = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1);
        if (newSlidesPerView !== slidesPerView) {
            location.reload(); 
        }
    });
});
</script>


