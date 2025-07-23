<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">🤖 Recommandations IA</h2>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            @forelse($aiRecommendations ?? [] as $recommendation)
                <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-{{ $recommendation['fromColor'] ?? 'blue' }}-50 to-{{ $recommendation['toColor'] ?? 'purple' }}-50 rounded-lg border border-{{ $recommendation['borderColor'] ?? 'blue' }}-200">
                    <div class="w-8 h-8 bg-{{ $recommendation['iconColor'] ?? 'blue' }}-500 rounded-full flex items-center justify-center flex-shrink-0">
                        {!! $recommendation['icon'] ?? '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 11-8.9-8.9 5 5 0 018.9 8.9z"></path></svg>' !!}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-{{ $recommendation['titleColor'] ?? 'blue' }}-900">{{ $recommendation['title'] ?? '' }}</p>
                        <p class="text-xs text-{{ $recommendation['descriptionColor'] ?? 'blue' }}-700 mt-1">{{ $recommendation['description'] ?? '' }}</p>
                    </div>
                </div>
            @empty
                <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 11-8.9-8.9 5 5 0 018.9 8.9z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-900">Optimisation nutrition</p>
                        <p class="text-xs text-blue-700 mt-1">Ajuster les portions de Max selon son activité réduite par la chaleur</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-green-50 to-teal-50 rounded-lg border border-green-200">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-900">Suivi Buddy</p>
                        <p class="text-xs text-green-700 mt-1">Programmer un bilan sanguin pour évaluer l'évolution de l'arthrite</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="2" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-purple-900">Planning optimal</p>
                        <p class="text-xs text-purple-700 mt-1">Matin idéal pour les activités physiques avec Luna</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
