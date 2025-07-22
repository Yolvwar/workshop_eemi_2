<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Boutique APWAP')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- PWA Meta -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#10b981">
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header Boutique -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('shop.index') }}" class="flex items-center space-x-3">
                        <img src="/logo.png" alt="APWAP" class="h-10 w-10">
                        <div>
                            <span class="text-xl font-bold text-gray-900">APWAP</span>
                            <span class="text-sm text-emerald-600 block leading-none">Boutique</span>
                        </div>
                    </a>
                </div>
                
                <!-- Barre de recherche centrale -->
                <div class="hidden md:flex flex-1 max-w-xl mx-8">
                    <form action="{{ route('shop.search') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" placeholder="Rechercher parmi 12,000+ produits premium..." 
                               class="w-full px-6 py-3 rounded-full text-gray-800 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all" 
                               value="{{ request('search') }}">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-emerald-600 text-white p-2 rounded-full hover:bg-emerald-700 transition-colors">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                        </button>
                    </form>
                </div>
                
                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-4">
                    <!-- Panier -->
                    <div class="relative group z-[90]">
                        <a href="{{ route('cart.index') }}" class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition-colors p-2 rounded-lg hover:bg-emerald-50">
                            <div class="relative">
                                <x-heroicon-o-shopping-cart class="w-6 h-6" />
                                @auth
                                @php
                                    $cart = auth()->user()->carts()->where('status', 'active')->first();
                                    $cartItemsCount = $cart?->items()->sum('quantity') ?? 0;
                                @endphp
                                @if($cartItemsCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-medium">
                                    {{ $cartItemsCount > 9 ? '9+' : $cartItemsCount }}
                                </span>
                                @endif
                                @endauth
                            </div>
                        </a>
                        
                        @auth
                        @if($cart && $cart->items->count() > 0)
                        <!-- Menu hover du panier -->
                        <div class="absolute right-0 top-full mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-[100]">
                            <!-- En-tête -->
                            <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                                        <x-heroicon-o-shopping-cart class="w-5 h-5" />
                                        Mon Panier
                                    </h3>
                                    <span class="text-sm text-emerald-600 font-medium">{{ $cartItemsCount }} article{{ $cartItemsCount > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                            
                            <!-- Articles du panier -->
                            <div class="max-h-80 overflow-y-auto">
                                @foreach($cart->items->take(4) as $item)
                                <div class="p-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center space-x-3">
                                        <!-- Image du produit -->
                                        <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-emerald-100 to-blue-100 flex items-center justify-center">
                                                    <x-heroicon-o-photo class="w-6 h-6 text-emerald-400" />
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Détails -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-medium text-gray-900 text-sm truncate">{{ $item->product->name }}</h4>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $item->quantity }} × {{ $item->unit_price }} AED
                                                @if($item->pet)
                                                    • <span class="text-emerald-600">Pour {{ $item->pet->name }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <!-- Prix -->
                                        <div class="text-right">
                                            <span class="font-semibold text-gray-900 text-sm">{{ $item->total_price }} AED</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                                @if($cart->items->count() > 4)
                                <div class="p-3 text-center">
                                    <span class="text-sm text-gray-500">{{ $cart->items->count() - 4 }} article(s) supplémentaire(s)...</span>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Résumé et actions -->
                            <div class="p-4 border-t border-gray-100 bg-gray-50">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="font-medium text-gray-700">Sous-total:</span>
                                    <span class="font-bold text-lg text-gray-900">{{ $cart->subtotal }} AED</span>
                                </div>
                                
                                @if($cart->subtotal >= 500)
                                <div class="mb-4 p-2 bg-green-100 rounded-lg">
                                    <p class="text-xs text-green-700 text-center">
                                        <x-heroicon-o-gift class="w-4 h-4 inline mr-1" /> <strong>Livraison gratuite incluse !</strong>
                                    </p>
                                </div>
                                @else
                                <div class="mb-4 p-2 bg-blue-100 rounded-lg">
                                    <p class="text-xs text-blue-700 text-center flex items-center justify-center gap-1">
                                        <x-heroicon-o-truck class="w-4 h-4 text-emerald-500" />
                                        Plus que <strong>{{ 500 - $cart->subtotal }} AED</strong> pour la livraison gratuite
                                    </p>
                                </div>
                                @endif
                                
                                <div class="space-y-2">
                                    <a href="{{ route('cart.index') }}" class="w-full flex justify-center items-center gap-2 bg-white text-emerald-600 py-2 px-4 rounded-lg text-sm font-medium text-center border border-emerald-200 hover:bg-emerald-50 transition-colors block">
                                        <x-heroicon-o-eye class="w-4 h-4" />
                                        Voir le panier
                                    </a>
                                    <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center gap-2 bg-emerald-600 text-white py-2 px-4 rounded-lg text-sm font-medium text-center hover:bg-emerald-700 transition-colors block">
                                        <x-heroicon-o-rocket-launch class="w-4 h-4" />
                                        Finaliser l'achat
                                    </a>
                                </div>
                            </div>
                        </div>
                        @elseif(auth()->check())
                        <!-- Menu panier vide -->
                        <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-[100]">
                            <div class="p-6 text-center">
                                <div class="mb-3">
                                    <x-heroicon-o-shopping-cart class="w-16 h-16 text-gray-400" />
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Votre panier est vide</h3>
                                <p class="text-sm text-gray-600 mb-4">Découvrez nos produits premium pour vos compagnons</p>
                                <a href="{{ route('shop.index') }}" class="w-full flex justify-center items-center gap-2 bg-emerald-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors inline-block">
                                    <x-heroicon-o-building-storefront class="w-4 h-4" />
                                    Découvrir la boutique
                                </a>
                            </div>
                        </div>
                        @endif
                        @endauth
                    </div>
                    
                    <!-- Notifications -->
                    @auth
                    <div class="relative group z-40">
                        <button class="text-gray-700 hover:text-emerald-600 transition-colors relative p-2 rounded-lg hover:bg-emerald-50">
                            <x-heroicon-o-bell class="w-6 h-6" />
                            <!-- Badge notifications -->
                            <span class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-medium">
                                3
                            </span>
                        </button>
                        
                        <!-- Dropdown notifications -->
                        <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-[70]">
                            <div class="p-4 border-b border-gray-100">
                                <h3 class="font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <span class="text-green-500 mt-1">
                                            <x-heroicon-o-check-circle class="w-4 h-4" />
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Commande expédiée</p>
                                            <p class="text-xs text-gray-600 mt-1">Votre commande #AP2024-1234 est en route</p>
                                            <p class="text-xs text-gray-500 mt-1">Il y a 2h</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <span class="text-blue-500 mt-1">
                                            <x-heroicon-o-gift class="w-4 h-4" />
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Promotion spéciale</p>
                                            <p class="text-xs text-gray-600 mt-1">-20% sur tous les jouets ce weekend</p>
                                            <p class="text-xs text-gray-500 mt-1">Il y a 1 jour</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <span class="text-orange-500 mt-1">
                                            <x-heroicon-o-exclamation-triangle class="w-4 h-4" />
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Stock limité</p>
                                            <p class="text-xs text-gray-600 mt-1">Plus que 3 articles de votre produit favori</p>
                                            <p class="text-xs text-gray-500 mt-1">Il y a 2 jours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border-t border-gray-100">
                                <button class="w-full text-center text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                    Voir toutes les notifications
                                </button>
                            </div>
                        </div>
                    </div>
                    @endauth
                    
                    <!-- Profil utilisateur -->
                    @auth
                    <div class="relative group z-40">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition-colors p-2 rounded-lg hover:bg-emerald-50">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ substr(auth()->user()->first_name, 0, 1) }}
                            </div>
                            <span class="hidden sm:inline font-medium">{{ auth()->user()->first_name }}</span>
                            <x-heroicon-o-chevron-down class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-200" />
                        </button>
                        
                        <!-- Dropdown profil -->
                        <div class="absolute right-0 top-full mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-[70]">
                            <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr(auth()->user()->first_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                        <p class="text-xs text-emerald-600 font-medium">{{ auth()->user()->city ?? 'Dubai' }}, UAE</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors group/item">
                                    <x-heroicon-o-rectangle-group class="w-5 h-5 mr-3 text-gray-400 group-hover/item:text-emerald-500" />
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors group/item">
                                    <x-heroicon-o-shopping-bag class="w-5 h-5 mr-3 text-gray-400 group-hover/item:text-emerald-500" />
                                    <span class="font-medium">Mes commandes</span>
                                </a>
                                <a href="{{ route('pets.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors group/item">
                                    <x-heroicon-o-heart class="w-5 h-5 mr-3 text-gray-400 group-hover/item:text-emerald-500" />
                                    <span class="font-medium">Mes animaux</span>
                                </a>
                                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors group/item">
                                    <x-heroicon-o-cog-6-tooth class="w-5 h-5 mr-3 text-gray-400 group-hover/item:text-emerald-500" />
                                    <span class="font-medium">Paramètres</span>
                                </a>
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors group/item">
                                            <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-3 text-gray-400 group-hover/item:text-red-500" />
                                            <span class="font-medium">Se déconnecter</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Boutons connexion/inscription pour invités -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-emerald-50">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors shadow-sm">
                            S'inscrire
                        </a>
                    </div>
                    @endauth
                    
                    <!-- Menu mobile -->
                    <button class="md:hidden text-gray-700 hover:text-emerald-600" onclick="toggleMobileMenu()">
                        <x-heroicon-o-bars-3 class="w-6 h-6" />
                    </button>
                </div>
            </div>
            
            <!-- Barre de recherche mobile -->
            <div class="md:hidden pb-4">
                <form action="{{ route('shop.search') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Rechercher des produits..." 
                           class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                           value="{{ request('search') }}">
                    <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-emerald-600">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Barre de navigation principale (en dessous du header) -->
        <div class="bg-gray-50 border-t border-gray-200 relative z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify- items-center">
                <nav class="hidden md:flex items-center justify-center space-x-8 py-3">
                    <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-white {{ request()->routeIs('shop.index') ? 'text-emerald-600 bg-white shadow-sm' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('shop.catalog') }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-white {{ request()->routeIs('shop.catalog') ? 'text-emerald-600 bg-white shadow-sm' : '' }}">
                        Catalogue
                    </a>
                    <div class="relative z-40" id="categories-dropdown">
                        <button 
                            class="text-gray-700 hover:text-emerald-600 font-medium transition-colors flex items-center px-3 py-2 rounded-lg hover:bg-white {{ request()->routeIs('shop.category') ? 'text-emerald-600 bg-white shadow-sm' : '' }}"
                            onmouseenter="showCategoriesDropdown()"
                            onmouseleave="hideCategoriesDropdown()"
                        >
                            Catégories
                            <x-heroicon-o-chevron-down id="categories-arrow" class="w-4 h-4 ml-1 transform transition-transform duration-200" />
                        </button>
                        <!-- Dropdown catégories -->
                        <div 
                            id="categories-menu"
                            class="absolute left-0 top-full mt-2 w-[520px] bg-white rounded-xl shadow-xl border border-gray-200 opacity-0 invisible transition-all duration-300 transform translate-y-2 z-[70]"
                            onmouseenter="showCategoriesDropdown()"
                            onmouseleave="hideCategoriesDropdown()"
                            style="pointer-events: none;"
                        >
                            <div class="p-4">
                                <div class="mb-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Catégories populaires</h3>
                                    <p class="text-xs text-gray-500">Découvrez nos produits par catégorie</p>
                                </div>
                                
                                @php
                                    $mainCategories = App\Models\ProductCategory::whereNull('parent_id')->with('children')->orderBy('sort_order')->take(6)->get();
                                @endphp
                                
                                <!-- Grille 3x2 rectangle horizontal -->
                                <div class="grid grid-cols-3 grid-rows-2 gap-3 mb-4">
                                    @foreach($mainCategories as $category)
                                    <a href="{{ route('shop.category', $category->slug) }}" 
                                       class="group/card flex flex-col items-center justify-center p-3 bg-gray-50 hover:bg-emerald-50 rounded-lg transition-all duration-200 hover:shadow-sm border border-transparent hover:border-emerald-200 h-20 min-w-0">
                                        <span class="text-xs font-medium text-gray-700 group-hover/card:text-emerald-600 text-center leading-tight truncate w-full pt-2">
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                    @endforeach
                                </div>
                                
                                <!-- Footer avec lien vers toutes catégories -->
                                <div class="border-t border-gray-100 pt-3">
                                    <a href="{{ route('shop.catalog') }}" 
                                       class="flex items-center justify-center w-full py-2 text-emerald-600 hover:bg-emerald-50 font-medium transition-colors rounded-lg text-sm group/link">
                                        <span>Voir toutes les catégories</span>
                                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover/link:translate-x-0.5 transition-transform" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Liens supplémentaires -->
                    <a href="{{ route('shop.search', ['featured' => 1]) }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-white">
                        Nouveautés
                    </a>
                    <a href="{{ route('shop.search', ['on_sale' => 1]) }}" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-white">
                        Promotions
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Menu mobile (caché par défaut) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('shop.index') }}" class="block py-2 text-gray-700 hover:text-emerald-600 font-medium flex items-center gap-2">
                    <x-heroicon-o-home class="w-4 h-4" />
                    Accueil
                </a>
                <a href="{{ route('shop.catalog') }}" class="block py-2 text-gray-700 hover:text-emerald-600 font-medium">
                    Catalogue
                </a>
                <a href="{{ route('shop.catalog') }}" class="block py-2 text-gray-700 hover:text-emerald-600 font-medium flex items-center gap-2">
                    <x-heroicon-o-tag class="w-4 h-4" />
                    Catégories
                </a>
            </div>
        </div>
    </header>
    
    <!-- Contenu principal -->
    <main>
        <!-- Flash Messages -->
        @if(session('success'))
        <div id="flash-success" class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform translate-x-full transition-transform duration-300">
            <x-heroicon-o-check-circle class="w-5 h-5" />
            <span>{{ session('success') }}</span>
            <button onclick="hideFlash('flash-success')" class="ml-2 text-white hover:text-gray-200">
                <x-heroicon-o-x-mark class="w-4 h-4" />
            </button>
        </div>
        @endif
        
        @if(session('error'))
        <div id="flash-error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform translate-x-full transition-transform duration-300">
            <x-heroicon-o-exclamation-circle class="w-5 h-5" />
            <span>{{ session('error') }}</span>
            <button onclick="hideFlash('flash-error')" class="ml-2 text-white hover:text-gray-200">
                <x-heroicon-o-x-mark class="w-4 h-4" />
            </button>
        </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer Boutique -->
    <footer class="mt-5 relative bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 text-white py-12 overflow-hidden">
        <!-- Effet de particules/cercles décoratifs -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-xl"></div>
            <div class="absolute top-32 right-20 w-24 h-24 bg-emerald-300 rounded-full blur-lg"></div>
            <div class="absolute bottom-20 left-1/3 w-40 h-40 bg-teal-300 rounded-full blur-2xl"></div>
            <div class="absolute bottom-10 right-10 w-28 h-28 bg-white rounded-full blur-xl"></div>
        </div>
        
        <!-- Overlay subtil -->
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/20 to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="/logo.png" alt="APWAP" class="h-8 w-8">
                        <span class="text-xl font-bold">APWAP Boutique</span>
                    </div>
                    <p class="text-emerald-100 mb-4">Votre partenaire de confiance pour le bien-être de vos animaux à Dubai.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-emerald-100 hover:text-white transition-colors transform hover:scale-110 duration-200">
                            <x-heroicon-o-device-phone-mobile class="w-5 h-5" />
                        </a>
                        <a href="#" class="text-emerald-100 hover:text-white transition-colors transform hover:scale-110 duration-200">
                            <x-heroicon-o-envelope class="w-5 h-5" />
                        </a>
                        <a href="#" class="text-emerald-100 hover:text-white transition-colors transform hover:scale-110 duration-200">
                            <x-heroicon-o-at-symbol class="w-5 h-5" />
                        </a>
                        <a href="#" class="text-emerald-100 hover:text-white transition-colors transform hover:scale-110 duration-200">
                            <x-heroicon-o-camera class="w-5 h-5" />
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Boutique</h3>
                    <ul class="space-y-2 text-emerald-100">
                        <li><a href="{{ route('shop.catalog') }}" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Catalogue</a></li>
                        <li><a href="{{ route('shop.catalog', ['category' => 'nutrition']) }}" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Nutrition</a></li>
                        <li><a href="{{ route('shop.catalog', ['category' => 'sante']) }}" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Santé</a></li>
                        <li><a href="{{ route('shop.catalog', ['category' => 'jouets']) }}" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Jouets</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Support</h3>
                    <ul class="space-y-2 text-emerald-100">
                        <li><a href="#" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Livraison & Retours</a></li>
                        <li><a href="#" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors hover:translate-x-1 duration-200 inline-block">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Livraison Dubai</h3>
                    <ul class="space-y-2 text-emerald-100 text-sm">
                        <li class="flex items-center gap-2 hover:text-white transition-colors">
                            <x-heroicon-o-truck class="w-4 h-4" />
                            Livraison gratuite >500 AED
                        </li>
                        <li class="flex items-center gap-2 hover:text-white transition-colors">
                            <x-heroicon-o-bolt class="w-4 h-4" />
                            Express 2h (+50 AED)
                        </li>
                        <li class="flex items-center gap-2 hover:text-white transition-colors">
                            <x-heroicon-o-truck class="w-4 h-4" />
                            Standard 24h
                        </li>
                        <li class="flex items-center gap-2 hover:text-white transition-colors">
                            <x-heroicon-o-credit-card class="w-4 h-4" />
                            Paiement sécurisé
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-emerald-400/30 mt-8 pt-8 text-center text-emerald-100">
                <p>&copy; {{ date('Y') }} APWAP Boutique. Tous droits réservés. Made with <x-heroicon-o-heart class="w-4 h-4 inline text-red-400" /> in Dubai.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
    
    <script>
        let categoriesTimeout;

        function showCategoriesDropdown() {
            clearTimeout(categoriesTimeout);
            const menu = document.getElementById('categories-menu');
            const arrow = document.getElementById('categories-arrow');
            
            menu.style.pointerEvents = 'auto';
            menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.add('opacity-100', 'visible', 'translate-y-0');
            arrow.classList.add('rotate-180');
        }

        function hideCategoriesDropdown() {
            categoriesTimeout = setTimeout(() => {
                const menu = document.getElementById('categories-menu');
                const arrow = document.getElementById('categories-arrow');
                
                menu.style.pointerEvents = 'none';
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                arrow.classList.remove('rotate-180');
            }, 150); 
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        function showFlash(id) {
            const flash = document.getElementById(id);
            if (flash) {
                setTimeout(() => {
                    flash.classList.remove('translate-x-full');
                }, 100);
                
                setTimeout(() => {
                    hideFlash(id);
                }, 5000);
            }
        }
        
        function hideFlash(id) {
            const flash = document.getElementById(id);
            if (flash) {
                flash.classList.add('translate-x-full');
                setTimeout(() => {
                    flash.remove();
                }, 300);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('flash-success')) {
                showFlash('flash-success');
            }
            if (document.getElementById('flash-error')) {
                showFlash('flash-error');
            }
        });
        
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('categories-dropdown');
            if (!dropdown.contains(event.target)) {
                hideCategoriesDropdown();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideCategoriesDropdown();
            }
        });
    </script>
</body>
</html>
