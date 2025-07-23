<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">⚡ Actions rapides</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($quickActions ?? [] as $action)
                <button class="flex flex-col items-center p-4 bg-{{ $action['color'] ?? 'purple' }}-50 rounded-lg hover:bg-{{ $action['color'] ?? 'purple' }}-100 transition-colors">
                    <div class="w-8 h-8 bg-{{ $action['color'] ?? 'purple' }}-500 rounded-lg flex items-center justify-center mb-2">
                        {!! $action['icon'] ?? '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>' !!}
                    </div>
                    <span class="text-sm font-medium text-gray-900">{{ $action['label'] ?? 'Action' }}</span>
                </button>
            @empty
                <button class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Ajouter note</span>
                </button>
                <button class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.89.52l1.11 2.18a1 1 0 00.89.53H20a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Voir dossiers</span>
                </button>
                <button class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Planifier RDV</span>
                </button>
                <button class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Commander</span>
                </button>
            @endforelse
        </div>
    </div>
</div>
