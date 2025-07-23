<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">🌤️ Météo & Impact</h2>
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-{{ $weather['iconColor'] ?? 'yellow' }}-100 rounded-full flex items-center justify-center">
                    {!! $weather['icon'] ?? '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 8a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>' !!}
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-900">{{ $weather['temperature'] ?? '32°C' }}</p>
                    <p class="text-sm text-gray-500">{{ $weather['description'] ?? 'Ensoleillé' }}, {{ $weather['location'] ?? 'Dubai' }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-{{ $weather['alertColor'] ?? 'orange' }}-600">{{ $weather['alertTitle'] ?? 'Température élevée' }}</p>
                <p class="text-xs text-gray-500">{{ $weather['alertSubtitle'] ?? 'Risque de stress thermique' }}</p>
            </div>
        </div>
        <div class="space-y-3">
            @forelse($weather['recommendations'] ?? [] as $recommendation)
                <div class="p-3 bg-{{ $recommendation['color'] ?? 'orange' }}-50 rounded-lg">
                    <p class="text-sm font-medium text-{{ $recommendation['color'] ?? 'orange' }}-800">{{ $recommendation['icon'] ?? '⚠️' }} {{ $recommendation['title'] ?? '' }}</p>
                    <p class="text-xs text-{{ $recommendation['color'] ?? 'orange' }}-700 mt-1">{{ $recommendation['description'] ?? '' }}</p>
                </div>
            @empty
                <div class="p-3 bg-orange-50 rounded-lg">
                    <p class="text-sm font-medium text-orange-800">⚠️ Recommandations</p>
                    <p class="text-xs text-orange-700 mt-1">Éviter les sorties entre 11h-16h</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">💧 Hydratation</p>
                    <p class="text-xs text-blue-700 mt-1">Vérifier l'eau fraîche disponible</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <p class="text-sm font-medium text-green-800">🌡️ Confort</p>
                    <p class="text-xs text-green-700 mt-1">Privilégier les espaces climatisés</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
