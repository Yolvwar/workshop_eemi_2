@props(['recommendations'])

<div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 mb-8 border-2 border-gray-200 shadow-lg">
    <h2 class="text-2xl font-semibold mb-6 flex items-center text-gray-900">
        🎯 Recommandations pour vos animaux
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recommendations as $petRec)
        <div class="bg-white border-2 border-gray-200 rounded-xl p-4 shadow-md">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-{{ $petRec['pet']->species === 'dog' ? 'blue' : ($petRec['pet']->species === 'cat' ? 'purple' : 'green') }}-400 to-{{ $petRec['pet']->species === 'dog' ? 'blue' : ($petRec['pet']->species === 'cat' ? 'purple' : 'green') }}-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ $petRec['pet']->species === 'dog' ? '🐕' : ($petRec['pet']->species === 'cat' ? '🐱' : '🐾') }}
                </div>
                <div class="ml-3">
                    <h3 class="font-semibold text-gray-900">{{ $petRec['pet']->name }}</h3>
                    <p class="text-sm text-gray-600">{{ ucfirst($petRec['pet']->breed) }}</p>
                </div>
            </div>
            <div class="space-y-2">
                @foreach($petRec['products']->take(2) as $product)
                <div class="flex justify-between items-center bg-gray-50 border border-gray-200 rounded-lg p-2">
                    <span class="text-sm text-gray-800">{{ Str::limit($product->name, 20) }}</span>
                    <span class="font-semibold text-emerald-600">{{ $product->price }} AED</span>
                </div>
                @endforeach
            </div>
            <a href="{{ route('shop.pet.recommendations', $petRec['pet']) }}" class="inline-block mt-3 bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                Voir tout →
            </a>
        </div>
        @endforeach
    </div>
</div>
