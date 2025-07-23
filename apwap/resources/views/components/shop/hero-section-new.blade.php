@props(['title', 'subtitle'])

<!-- Commercial Hero Section - Style harmonisé avec fond blanc -->
<div class="relative">
    <!-- Main Banner -->
    <div class="relative h-96 md:h-[450px] overflow-hidden rounded-2xl mb-6 bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 border border-gray-200">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/10 via-teal-600/10 to-cyan-600/10"></div>
        <div class="relative h-full flex items-center justify-between px-8 md:px-16">
            <!-- Left Content -->
            <div class="text-gray-900 max-w-xl">
                <div class="inline-block bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold mb-4 animate-pulse">
                    🔥 OFFRE LIMITÉE
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight text-gray-900">
                    Jusqu'à <span class="text-emerald-600">70% OFF</span>
                </h1>
                <p class="text-xl md:text-2xl mb-6 text-gray-700">
                    Sur une sélection premium pour vos animaux
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="bg-emerald-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-emerald-700 transition-colors shadow-lg">
                        🛍️ PROFITER MAINTENANT
                    </button>
                    <button class="border-2 border-emerald-600 text-emerald-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-emerald-50 transition-colors">
                        📱 Télécharger l'App
                    </button>
                </div>
            </div>
            
            <!-- Right Image/Product -->
            <div class="hidden md:block relative">
                <div class="w-80 h-80 relative">
                    <div class="absolute inset-0 bg-emerald-100/50 backdrop-blur-sm rounded-full"></div>
                    <div class="absolute top-8 left-8 w-64 h-64 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-xl border border-emerald-200">
                        <span class="text-8xl">🐕🐱</span>
                    </div>
                    <!-- Floating Product Cards -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-lg p-3 shadow-xl animate-bounce border border-green-200">
                        <div class="text-sm font-bold text-gray-800">Livraison</div>
                        <div class="text-xs text-green-600">GRATUITE</div>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-red-500 text-white rounded-lg p-3 shadow-xl animate-bounce border" style="animation-delay: 0.5s">
                        <div class="text-sm font-bold">-50%</div>
                        <div class="text-xs">MEGA DEAL</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="quick-action-card bg-white border-2 border-green-200 text-green-700 p-4 rounded-xl text-center hover:scale-105 hover:shadow-lg transition-all cursor-pointer relative overflow-hidden">
            <div class="text-2xl mb-2">🚚</div>
            <div class="font-bold text-sm">Livraison Express</div>
            <div class="text-xs opacity-70">24h Dubai</div>
        </div>
        <div class="quick-action-card bg-white border-2 border-orange-200 text-orange-700 p-4 rounded-xl text-center hover:scale-105 hover:shadow-lg transition-all cursor-pointer relative overflow-hidden">
            <div class="text-2xl mb-2">💰</div>
            <div class="font-bold text-sm">Prix Cassés</div>
            <div class="text-xs opacity-70">Jusqu'à -70%</div>
        </div>
        <div class="quick-action-card bg-white border-2 border-purple-200 text-purple-700 p-4 rounded-xl text-center hover:scale-105 hover:shadow-lg transition-all cursor-pointer relative overflow-hidden">
            <div class="text-2xl mb-2">⭐</div>
            <div class="font-bold text-sm">Qualité Premium</div>
            <div class="text-xs opacity-70">Marques top</div>
        </div>
        <div class="quick-action-card bg-white border-2 border-blue-200 text-blue-700 p-4 rounded-xl text-center hover:scale-105 hover:shadow-lg transition-all cursor-pointer relative overflow-hidden">
            <div class="text-2xl mb-2">🎯</div>
            <div class="font-bold text-sm">Conseils Perso</div>
            <div class="text-xs opacity-70">Par vétérinaires</div>
        </div>
    </div>

    <!-- Flash Sales Banner -->
    <div class="bg-white border-2 border-red-200 p-4 rounded-xl mb-6 relative overflow-hidden shadow-lg">
        <div class="absolute inset-0 bg-gradient-to-r from-red-50 to-pink-50"></div>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-3xl animate-bounce">⚡</div>
                <div>
                    <div class="font-black text-lg text-red-600">VENTES FLASH</div>
                    <div class="text-sm text-gray-600">Se termine dans</div>
                </div>
                <div class="hidden md:flex space-x-2">
                    <div class="bg-red-100 border border-red-200 px-3 py-2 rounded text-center">
                        <div class="font-bold countdown-hour text-red-600">02</div>
                        <div class="text-xs text-red-500">H</div>
                    </div>
                    <div class="bg-red-100 border border-red-200 px-3 py-2 rounded text-center">
                        <div class="font-bold countdown-min text-red-600">45</div>
                        <div class="text-xs text-red-500">M</div>
                    </div>
                    <div class="bg-red-100 border border-red-200 px-3 py-2 rounded text-center">
                        <div class="font-bold countdown-sec text-red-600">12</div>
                        <div class="text-xs text-red-500">S</div>
                    </div>
                </div>
            </div>
            <button class="bg-red-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-600 transition-colors shadow-lg">
                VOIR LES OFFRES →
            </button>
        </div>
    </div>
</div>
