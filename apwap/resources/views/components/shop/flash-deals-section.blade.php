@props(['flashDeals' => null])

@if($flashDeals && count($flashDeals) > 0)
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="text-3xl">⚡</div>
                <div>
                    <h2 class="text-2xl font-black text-red-600">DEALS FLASH</h2>
                    <p class="text-sm text-gray-600">Offres limitées - Dépêchez-vous !</p>
                </div>
            </div>
            <button class="text-red-600 font-bold hover:text-red-700">
                Voir tout →
            </button>
        </div>

        <!-- Flash Deals Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($flashDeals as $deal)
            <div class="bg-white border-2 border-red-200 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105 relative flex flex-col h-full">
                <!-- Discount Badge -->
                <div class="absolute top-2 left-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10 shadow-lg">
                    -{{ $deal['discount'] }}%
                </div>
                
                <!-- Timer Badge -->
                <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full z-10">
                    ⏰ {{ $deal['timeLeft'] }}
                </div>

                <!-- Product Image -->
                <div class="aspect-square overflow-hidden bg-gray-100 flex-shrink-0">
                    <img src="{{ $deal['product']->image_url ?? '/logo.png' }}" 
                         alt="{{ $deal['product']->name }}" 
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                </div>

                <!-- Product Info -->
                <div class="p-3 flex flex-col flex-grow">
                    <h3 class="font-bold text-sm mb-2 line-clamp-2 text-gray-900">{{ $deal['product']->name }}</h3>
                    
                    <!-- Price Section -->
                    <div class="space-y-1 mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-black text-red-600">{{ $deal['flashPrice'] }} AED</span>
                        </div>
                        <div class="text-xs text-gray-500 line-through">{{ $deal['originalPrice'] }} AED</div>
                        <div class="text-xs text-green-600 font-bold">Économisez {{ $deal['savings'] }} AED</div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Vendu: {{ $deal['sold'] }}</span>
                            <span>Stock: {{ $deal['remaining'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-400 to-red-500 h-2 rounded-full shadow-sm" 
                                 style="width: {{ ($deal['sold'] / ($deal['sold'] + $deal['remaining'])) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Spacer pour pousser le bouton vers le bas -->
                    <div class="flex-grow"></div>

                    <!-- Buy Button (Always at bottom) -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $deal['product']->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-2.5 rounded-lg font-bold hover:from-red-600 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg text-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            ACHETER
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Bottom CTA -->
        <div class="text-center mt-8">
            <button class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all">
                🔥 VOIR TOUS LES DEALS FLASH
            </button>
        </div>
    </div>
</div>
@endif
