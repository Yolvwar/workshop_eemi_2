<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-gray-900">Vos Animaux</h3>
                    <p class="text-sm text-gray-500">{{ $animalsCount ?? 3 }} actifs</p>
                </div>
            </div>
            <span class="text-2xl font-bold text-green-600">{{ $healthScore ?? 87 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $healthScore ?? 87 }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2">Score global bien-être</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-gray-900">Vos rendez-vous</h3>
                    <p class="text-sm text-gray-500">{{ $appointmentsCount ?? 2 }} prévus</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-900">{{ $appointmentTimes ?? '14h & 16h30' }}</p>
                <p class="text-xs text-gray-500">Aujourd'hui</p>
            </div>
        </div>
        <button class="w-full bg-blue-50 text-blue-700 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors">
            Voir planning
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-gray-900">Commandes</h3>
                    <p class="text-sm text-gray-500">{{ $ordersCount ?? 1 }} en cours</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-900">{{ $deliveryTime ?? 'Livraison 2j' }}</p>
                <p class="text-xs text-gray-500">Tracking actif</p>
            </div>
        </div>
        <button class="w-full bg-purple-50 text-purple-700 py-2 rounded-lg text-sm font-medium hover:bg-purple-100 transition-colors">
            Suivre commande
        </button>
    </div>
</div>
