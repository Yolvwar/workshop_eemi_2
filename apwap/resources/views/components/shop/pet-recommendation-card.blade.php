@props(['petRec'])

<div class="bg-white/10 backdrop-blur-md rounded-xl p-4 transition-transform duration-300 hover:scale-105">
    <div class="flex items-center mb-3">
        <span class="text-2xl mr-3">{{ $petRec['pet']->species === 'chat' ? '🐱' : '🐶' }}</span>
        <div>
            <h3 class="font-semibold">{{ $petRec['pet']->name }}</h3>
            <p class="text-sm opacity-70">{{ ucfirst($petRec['pet']->species) }} • {{ $petRec['pet']->breed }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2">
        @foreach($petRec['recommendations'] as $product)
        <div class="bg-white/20 rounded-lg p-2 text-center">
            <img src="{{ $product->image_url ?? '/logo.png' }}" 
                 alt="{{ $product->name }}" 
                 class="w-12 h-12 object-cover rounded-lg mx-auto mb-1">
            <p class="text-xs font-medium">{{ $product->name }}</p>
            <p class="text-xs text-orange-300 font-bold">{{ number_format($product->price, 2) }}€</p>
        </div>
        @endforeach
    </div>
</div>
