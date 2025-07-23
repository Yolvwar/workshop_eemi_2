@props(['popularProducts'])

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tendances Dubai</h2>
            <p class="text-lg text-gray-600">Les plus populaires cette semaine</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularProducts as $product)
            <x-shop.popular-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</div>

