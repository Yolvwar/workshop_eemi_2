<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">📅 Planning de la semaine</h2>
            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</button>
        </div>
    </div>
    <div class="p-6">
        @if(isset($weeklySchedule) && count($weeklySchedule) > 0)
            <div class="space-y-4">
                @foreach($weeklySchedule as $day => $events)
                    <div class="border-l-4 border-{{ $events['color'] ?? 'blue' }}-500 pl-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-900">{{ $day }}</h4>
                            <span class="text-xs text-gray-500">{{ count($events['items'] ?? []) }} événement(s)</span>
                        </div>
                        <div class="space-y-2">
                            @foreach($events['items'] ?? [] as $event)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-{{ $event['color'] ?? 'blue' }}-600">{{ $event['icon'] ?? '📅' }}</span>
                                        <span class="text-sm text-gray-900">{{ $event['title'] ?? '' }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $event['time'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-4">
                <div class="border-l-4 border-blue-500 pl-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">Aujourd'hui</h4>
                        <span class="text-xs text-gray-500">3 événements</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 bg-red-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-red-600">🏥</span>
                                <span class="text-sm text-gray-900">RDV vétérinaire - Buddy</span>
                            </div>
                            <span class="text-xs text-gray-500">14h00</span>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-green-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-green-600">🍽️</span>
                                <span class="text-sm text-gray-900">Repas spécial - Max</span>
                            </div>
                            <span class="text-xs text-gray-500">16h30</span>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-purple-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-purple-600">🎾</span>
                                <span class="text-sm text-gray-900">Séance jeu - Luna</span>
                            </div>
                            <span class="text-xs text-gray-500">18h00</span>
                        </div>
                    </div>
                </div>

                <div class="border-l-4 border-purple-500 pl-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">Demain</h4>
                        <span class="text-xs text-gray-500">2 événements</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 bg-blue-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-blue-600">✂️</span>
                                <span class="text-sm text-gray-900">Toilettage - Luna</span>
                            </div>
                            <span class="text-xs text-gray-500">10h00</span>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-orange-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-orange-600">🏃</span>
                                <span class="text-sm text-gray-900">Promenade - Max & Buddy</span>
                            </div>
                            <span class="text-xs text-gray-500">17h00</span>
                        </div>
                    </div>
                </div>

                <div class="border-l-4 border-green-500 pl-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">Cette semaine</h4>
                        <span class="text-xs text-gray-500">4 événements</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 bg-yellow-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-yellow-600">💊</span>
                                <span class="text-sm text-gray-900">Contrôle traitement - Buddy</span>
                            </div>
                            <span class="text-xs text-gray-500">Vendredi</span>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-indigo-50 rounded">
                            <div class="flex items-center space-x-2">
                                <span class="text-indigo-600">📦</span>
                                <span class="text-sm text-gray-900">Livraison croquettes</span>
                            </div>
                            <span class="text-xs text-gray-500">Samedi</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
