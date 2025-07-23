@props(['placeholder' => 'Rechercher parmi 12,000+ produits premium...', 'searchRoute' => 'shop.search'])

<div class="max-w-2xl mx-auto">
    <form action="{{ route($searchRoute) }}" method="GET" class="relative">
        <input type="text" name="search" placeholder="{{ $placeholder }}" 
               class="w-full px-6 py-4 rounded-full text-gray-800 bg-white border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-lg" 
               value="{{ request('search') }}">
        <button type="submit" class="absolute right-2 top-2 bg-emerald-600 text-white p-2 rounded-full hover:bg-emerald-700 transition-colors shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </form>
</div>
