@props([])

<div class="bg-gradient-to-r from-emerald-500 to-teal-600 py-12">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-4 flex items-center justify-center gap-2">
            <x-heroicon-o-user-group class="w-8 h-8" />
            Personnalisez votre expérience
        </h2>
        <p class="text-xl text-white/90 mb-8">Ajoutez vos animaux pour des recommandations sur mesure</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('pets.index') }}" class="bg-white text-emerald-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                <x-heroicon-o-clipboard-document-list class="w-5 h-5" />
                Gérer mes animaux
            </a>
            <a href="{{ route('shop.catalog') }}" class="bg-white/20 text-white px-8 py-3 rounded-full font-semibold hover:bg-white/30 transition-colors border border-white/30 flex items-center justify-center gap-2">
                <x-heroicon-o-shopping-bag class="w-5 h-5" />
                Explorer le catalogue
            </a>
        </div>
    </div>
</div>
