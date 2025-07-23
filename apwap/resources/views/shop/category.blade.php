@extends('layouts.shop')

@section('title', $category->name . ' - Boutique APWAP')
@section('page-title', $category->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header de la catégorie -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                        <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition-colors">Boutique</a>
                        <x-heroicon-o-chevron-right class="w-4 h-4" />
                        <a href="{{ route('shop.catalog') }}" class="hover:text-emerald-600 transition-colors">Catalogue</a>
                        <x-heroicon-o-chevron-right class="w-4 h-4" />
                        <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                    </nav>
                    
                    <div class="mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} disponible{{ $products->total() > 1 ? 's' : '' }}</p>
                    </div>
                    
                    @if($category->description)
                    <p class="text-gray-600 max-w-2xl">{{ $category->description }}</p>
                    @endif
                </div>
                
                <!-- Actions rapides -->
                <div class="flex flex-wrap gap-3">
                    <button onclick="toggleFilters()" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-medium hover:bg-emerald-200 transition-colors flex items-center gap-2">
                        <x-heroicon-o-adjustments-horizontal class="w-4 h-4" />
                        Filtres
                    </button>
                    <a href="{{ route('shop.catalog') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors flex items-center gap-2">
                        <x-heroicon-o-arrow-left class="w-4 h-4" />
                        Catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filtres -->
            <div id="filters-sidebar" class="hidden lg:block">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-36 z-40">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Affiner la recherche</h3>
                    
                    <form action="{{ route('shop.category', $category->slug) }}" method="GET" id="filters-form">
                        <!-- Recherche dans la catégorie -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Rechercher dans {{ $category->name }}..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Espèces d'animaux -->
                        @if($pets->isNotEmpty())
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pour vos animaux</label>
                            <div class="space-y-2">
                                @foreach($pets->unique('species') as $pet)
                                <label class="flex items-center">
                                    <input type="radio" name="species" value="{{ $pet->species }}" 
                                           {{ request('species') == $pet->species ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" 
                                           onchange="this.form.submit()">
                                    <span class="ml-2 text-sm text-gray-700 capitalize">
                                        {{ $pet->species === 'dog' ? 'Chiens' : ($pet->species === 'cat' ? 'Chats' : ucfirst($pet->species)) }}
                                    </span>
                                </label>
                                @endforeach
                                <label class="flex items-center">
                                    <input type="radio" name="species" value="" 
                                           {{ !request('species') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" 
                                           onchange="this.form.submit()">
                                    <span class="ml-2 text-sm text-gray-700">Tous les animaux</span>
                                </label>
                            </div>
                        </div>
                        @endif

                        <!-- Prix -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (AED)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="price_min" value="{{ request('price_min') }}" 
                                       placeholder="Min" min="0" 
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <input type="number" name="price_max" value="{{ request('price_max') }}" 
                                       placeholder="Max" min="0" 
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Note minimum</label>
                            <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" onchange="this.form.submit()">
                                <option value="">Toutes les notes</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ étoiles</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ étoiles</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ étoiles</option>
                            </select>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full bg-emerald-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                Appliquer les filtres
                            </button>
                            <a href="{{ route('shop.category', $category->slug) }}" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center block">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-3">
                <!-- Barre de tri mobile/desktop -->
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                            <span class="text-sm text-gray-600">
                                {{ $products->firstItem() }}-{{ $products->lastItem() }} sur {{ $products->total() }} résultats
                            </span>
                            @if(request('search'))
                            <span class="text-sm text-emerald-600 bg-emerald-50 px-2 py-1 rounded">
                                "{{ request('search') }}"
                            </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Tri -->
                            <form action="{{ route('shop.category', $category->slug) }}" method="GET" class="flex items-center space-x-2">
                                @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('species'))
                                <input type="hidden" name="species" value="{{ request('species') }}">
                                @endif
                                @if(request('price_min'))
                                <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                                @endif
                                @if(request('price_max'))
                                <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                                @endif
                                @if(request('rating'))
                                <input type="hidden" name="rating" value="{{ request('rating') }}">
                                @endif
                                
                                <label class="text-sm text-gray-600">Trier par:</label>
                                <select name="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularité</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Mieux notés</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Grille de produits -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                    <x-shop.product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @else
                <!-- État vide -->
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="mb-6">
                            <x-heroicon-o-magnifying-glass class="w-16 h-16 text-gray-400 mx-auto" />
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
                        <p class="text-gray-600 mb-6">
                            @if(request()->hasAny(['search', 'species', 'price_min', 'price_max', 'rating']))
                                Essayez de modifier vos critères de recherche ou de réinitialiser les filtres.
                            @else
                                Cette catégorie ne contient pas encore de produits.
                            @endif
                        </p>
                        <div class="space-y-3">
                            @if(request()->hasAny(['search', 'species', 'price_min', 'price_max', 'rating']))
                            <a href="{{ route('shop.category', $category->slug) }}" class="inline-block bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                Réinitialiser les filtres
                            </a>
                            @endif
                            <a href="{{ route('shop.catalog') }}" class="inline-block bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                Explorer le catalogue
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFilters() {
        const sidebar = document.getElementById('filters-sidebar');
        sidebar.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('filters-sidebar');
        
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('hidden');
        }
        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection
