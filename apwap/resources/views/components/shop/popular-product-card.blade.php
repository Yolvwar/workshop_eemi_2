@props(['product'])

<div class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 group flex flex-col h-full">
    <div class="p-6 flex flex-col h-full">
        <div class="flex items-start space-x-4 mb-4">
            <!-- Product Image -->
            <div class="relative flex-shrink-0">
                @if($product->images && count($product->images) > 0)
                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-28 h-28 object-cover rounded-xl group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-28 h-28 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                    <x-heroicon-o-cube class="w-8 h-8 text-gray-400" />
                </div>
                @endif
                
                <!-- Trending Badge -->
                <div class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-lg flex items-center gap-1">
                    <x-heroicon-o-fire class="w-3 h-3" />
                    HOT
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="flex-1 min-w-0">
                <div class="mb-2">
                    <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        {{ $product->category->name }}
                    </span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2 text-base group-hover:text-emerald-600 transition-colors leading-tight">
                    {{ Str::limit($product->name, 40) }}
                </h3>
                
                <!-- Description -->
                @if($product->short_description)
                <p class="text-sm text-gray-600 mb-3 leading-relaxed">{{ Str::limit($product->short_description, 60) }}</p>
                @endif
                
                <!-- Rating -->
                @if($product->rating > 0)
                <div class="flex items-center mb-3">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->rating))
                            <x-heroicon-o-star class="w-4 h-4 text-yellow-400 fill-yellow-400" />
                            @else
                            <x-heroicon-o-star class="w-4 h-4 text-gray-300" />
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 ml-2">({{ $product->rating }})</span>
                </div>
                @endif
                
                <!-- Price -->
                <div class="flex items-center space-x-2">
                    <span class="text-lg font-bold text-gray-900">{{ $product->price }} AED</span>
                    @if($product->original_price && $product->original_price > $product->price)
                    <span class="text-sm text-gray-500 line-through">{{ $product->original_price }} AED</span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Spacer pour pousser les boutons vers le bas -->
        <div class="flex-grow"></div>
        
        <!-- Action Buttons (Always at bottom) -->
        <div class="flex space-x-3 mt-auto">
            <a href="{{ route('shop.product', $product->slug) }}" class="flex-1 bg-white text-gray-700 py-2.5 px-4 rounded-lg text-center text-sm font-medium hover:bg-gray-50 transition-colors border border-gray-300 hover:border-gray-400">
                Voir détails
            </a>
            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-2.5 px-4 rounded-lg text-sm font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <x-heroicon-o-shopping-cart class="w-4 h-4" />
                    Ajouter
                </button>
            </form>
        </div>
    </div>
</div>
