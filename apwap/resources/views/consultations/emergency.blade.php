@extends('layouts.app')

@section('title', 'Centre d\'Urgences')
@section('page-title', 'Centre d\'Urgences 24/7')

@section('content')
<div class="w-full">
    <!-- Header d'urgence -->
    <div class="bg-red-600 text-white rounded-2xl p-8 text-center mb-8">
        <h1 class="text-3xl font-bold mb-4">🚨 Urgences APWAP 24/7</h1>
        <div class="space-y-4">
            <a href="tel:+971-4-XXX-XXXX" 
               class="inline-block bg-white text-red-600 px-8 py-4 rounded-xl font-bold text-xl hover:bg-red-50 transition-colors">
                📞 +971-4-XXX-XXXX
            </a>
            <p class="text-red-100">Hotline disponible 24h/24, 7j/7</p>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Ambulance -->
        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
            <div class="text-4xl mb-4">🚑</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Ambulance</h3>
            <p class="text-gray-600 text-sm mb-4">Transport d'urgence</p>
            <a href="tel:+971-4-XXX-XXXX" 
               class="w-full bg-red-600 text-white py-3 rounded-xl font-medium hover:bg-red-700 transition-colors block">
                Demander
            </a>
        </div>

        <!-- Téléconsultation -->
        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
            <div class="text-4xl mb-4">💻</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Téléconsultation</h3>
            <p class="text-gray-600 text-sm mb-4">Conseil immédiat</p>
            <a href="{{ route('consultations.teleconsultation.emergency') }}" 
               class="w-full bg-emerald-600 text-white py-3 rounded-xl font-medium hover:bg-emerald-700 transition-colors block">
                Démarrer
            </a>
        </div>

        <!-- RDV Urgence -->
        <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
            <div class="text-4xl mb-4">⚡</div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">RDV Urgence</h3>
            <p class="text-gray-600 text-sm mb-4">Créneaux prioritaires</p>
            <a href="{{ route('consultations.create', ['urgency' => 'urgent']) }}" 
               class="w-full bg-orange-600 text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors block">
                Réserver
            </a>
        </div>
    </div>

    <!-- Évaluation rapide -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">⚠️ Mon animal a besoin d'aide ?</h2>
        </div>
        <div class="p-6 space-y-4">
            <!-- Critique -->
            <div class="border-l-4 border-red-600 bg-red-50 p-4 rounded-r-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-red-800 mb-1">🔴 Urgence vitale</h3>
                        <p class="text-red-700 text-sm">Convulsions, difficultés respiratoires, saignements</p>
                    </div>
                    <a href="tel:+971-4-XXX-XXXX" 
                       class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors text-sm">
                        Appeler
                    </a>
                </div>
            </div>

            <!-- Urgent -->
            <div class="border-l-4 border-orange-500 bg-orange-50 p-4 rounded-r-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-orange-800 mb-1">🟡 Urgent (2-4h)</h3>
                        <p class="text-orange-700 text-sm">Vomissements, diarrhée, boiterie, fièvre</p>
                    </div>
                    <a href="{{ route('consultations.create', ['urgency' => 'urgent']) }}" 
                       class="bg-orange-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors text-sm">
                        RDV Urgent
                    </a>
                </div>
            </div>

            <!-- Non-urgent -->
            <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-green-800 mb-1">� Peut attendre</h3>
                        <p class="text-green-700 text-sm">Questions générales, contrôles de routine</p>
                    </div>
                    <a href="{{ route('consultations.create') }}" 
                       class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors text-sm">
                        RDV Normal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cliniques d'urgence -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">🏥 Cliniques d'urgence</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($emergencyClinics as $clinic)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $clinic['name'] }}</h3>
                        <p class="text-gray-600 text-sm">{{ $clinic['distance'] }} • Ouvert 24/7</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="tel:{{ $clinic['phone'] }}" 
                           class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                            📞
                        </a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            🗺️
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
