@props(['product', 'featured' => false])

<div class="bg-white/20 backdrop-blur-md rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 hover:bg-white/30">
    <div class="relative">
        <div class="aspect-square overflow-hidden">
            @if($product->images && count($product->images) > 0)
            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" 
                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            @else
            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <x-heroicon-o-cube class="w-12 h-12 text-gray-400" />
            </div>
            @endif
        </div>
        
        @if($product->original_price && $product->original_price > $product->price)
        <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
            -{{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
        </div>
        @endif
        
        @if($product->featured || $featured)
        <div class="absolute top-3 right-3 bg-yellow-500 text-white p-1 rounded-full">
            <x-heroicon-o-star class="w-4 h-4" />
        </div>
        @endif
    </div>
    
    <div class="p-4">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs bg-orange-500 text-white px-2 py-1 rounded-full">
                {{ $product->category->name }}
            </span>
            @if($product->is_featured || $featured)
            <span class="text-xs bg-yellow-500 text-black px-2 py-1 rounded-full flex items-center gap-1">
                <x-heroicon-o-star class="w-3 h-3" />
                Vedette
            </span>
            @endif
        </div>
        <h3 class="font-semibold mb-2 line-clamp-2">{{ $product->name }}</h3>
        @if($product->short_description)
        <p class="text-sm opacity-70 mb-3 line-clamp-2">{{ $product->short_description }}</p>
        @endif
        
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <span class="text-lg font-bold text-orange-300">{{ $product->price }} AED</span>
                @if($product->original_price && $product->original_price > $product->price)
                <span class="text-sm text-gray-300 line-through">{{ $product->original_price }} AED</span>
                @endif
            </div>
            @if($product->rating > 0)
            <div class="flex items-center">
                <x-heroicon-o-star class="w-4 h-4 text-yellow-400 fill-yellow-400" />
                <span class="text-sm text-gray-300 ml-1">{{ $product->rating }}</span>
            </div>
            @endif
        </div>
        
        <div class="flex space-x-2">
            <a href="{{ route('shop.product', $product->slug) }}" class="flex-1 bg-orange-500 text-white py-2 px-4 rounded-lg text-center text-sm font-medium hover:bg-orange-600 transition-colors">
                Voir détails
            </a>
            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-white/20 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-white/30 transition-colors flex items-center justify-center gap-1">
                    <x-heroicon-o-shopping-cart class="w-4 h-4" />
                    Ajouter
                </button>
            </form>
        </div>
    </div>
</div>
