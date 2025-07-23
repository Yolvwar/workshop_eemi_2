@props(['categories'])

<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center flex items-center justify-center gap-2">
        <x-heroicon-o-trophy class="w-8 h-8 text-yellow-500" />
        Catégories Premium
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('shop.category', $category->slug) }}" class="group">
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105 border border-gray-100">
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $category->products_count ?? 0 }}+ produits</p>
                    @if($category->description)
                    <p class="text-xs text-gray-500">{{ Str::limit($category->description, 50) }}</p>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
