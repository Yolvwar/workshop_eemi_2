@extends('layouts.app')

@section('title', 'Consultations Vétérinaires - APWAP')
@section('page-title', 'Consultations Vétérinaires')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 display: flex; flex-direction: column; gap: 8px;">
        <!-- Header Premium -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Consultations Vétérinaires
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Prenez soin de vos compagnons avec nos vétérinaires experts à {{ auth()->user()->location ?? 'Dubai, UAE' }}
            </p>
            <div class="mt-4 inline-flex items-center px-4 py-2 bg-emerald-100 rounded-full">
                <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                <span class="text-emerald-700 font-medium">{{ $upcomingConsultations->count() }} rendez-vous à venir</span>
            </div>
        </div>

        <!-- Actions rapides Premium -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('consultations.create') }}" class="group relative bg-emerald-50 hover:bg-emerald-100 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-calendar class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Consultation</h3>
                    <p class="text-sm text-gray-600 mb-4">Rendez-vous programmé avec nos vétérinaires</p>
                    <div class="flex items-center text-emerald-600 font-medium">
                        <span>Prendre RDV</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <a href="{{ route('consultations.emergency') }}" class="group relative bg-red-50 hover:bg-red-100 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Urgence 24/7</h3>
                    <p class="text-sm text-gray-600 mb-4">Service d'urgence disponible jour et nuit</p>
                    <div class="flex items-center text-red-600 font-medium">
                        <span>Urgence</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <a href="{{ route('consultations.teleconsultation.create') }}" class="group relative bg-blue-50 hover:bg-blue-100 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-video-camera class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Téléconsultation</h3>
                    <p class="text-sm text-gray-600 mb-4">Consultation à distance depuis chez vous</p>
                    <div class="flex items-center text-blue-600 font-medium">
                        <span>Démarrer</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <a href="{{ route('consultations.history') }}" class="group relative bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-gray-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-clock class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Historique</h3>
                    <p class="text-sm text-gray-600 mb-4">Consultez vos précédents rendez-vous</p>
                    <div class="flex items-center text-gray-600 font-medium">
                        <span>Voir tout</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Prochains Rendez-vous -->
                @if($upcomingConsultations->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <x-heroicon-o-calendar-days class="w-5 h-5 inline mr-2" /> 
                            Prochains Rendez-vous
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach($upcomingConsultations as $consultation)
                            <div class="border-l-4 border-emerald-500 bg-emerald-50 pl-6 pr-4 py-4 rounded-r-lg">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex-1 mb-3 sm:mb-0">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="text-lg font-semibold text-gray-900">
                                                @php
                                                    $date = \Carbon\Carbon::parse($consultation->scheduled_date);
                                                    $time = \Carbon\Carbon::parse($consultation->scheduled_time);
                                                @endphp
                                                {{ $date->format('l j M') }} - {{ $time->format('H\hi') }}
                                            </span>
                                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                                @if($consultation->priority === 'urgent') bg-red-100 text-red-800
                                                @elseif($consultation->priority === 'high') bg-orange-100 text-orange-800
                                                @elseif($consultation->priority === 'medium') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($consultation->priority) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                @if($consultation->pet->species === 'dog')
                                                    🐕 {{ $consultation->pet->name }}
                                                @elseif($consultation->pet->species === 'cat')
                                                    🐱 {{ $consultation->pet->name }}
                                                @else
                                                    🐾 {{ $consultation->pet->name }}
                                                @endif
                                            </span>
                                            <span class="flex items-center">
                                                <x-heroicon-o-user-circle class="w-4 h-4 mr-1" />
                                                Dr. {{ $consultation->veterinarian->first_name }} {{ $consultation->veterinarian->last_name }}
                                            </span>
                                            <span class="flex items-center">
                                                @if($consultation->mode === 'teleconsultation')
                                                    <x-heroicon-o-video-camera class="w-4 h-4 mr-1" />
                                                    Téléconsultation
                                                @elseif($consultation->mode === 'home_visit')
                                                    <x-heroicon-o-home class="w-4 h-4 mr-1" />
                                                    À domicile
                                                @else
                                                    <x-heroicon-o-building-office class="w-4 h-4 mr-1" />
                                                    En clinique
                                                @endif
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-2">
                                            <strong>Type:</strong> {{ ucfirst($consultation->type) }}
                                            @if($consultation->symptoms)
                                                • <strong>Symptômes:</strong> {{ Str::limit($consultation->symptoms, 50) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('consultations.show', $consultation) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                                            Voir détails
                                        </a>
                                        @if($consultation->mode === 'teleconsultation')
                                            <a href="{{ route('consultations.teleconsultation', $consultation) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                                Rejoindre
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <x-heroicon-o-calendar-days class="w-8 h-8 text-gray-400" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun rendez-vous à venir</h3>
                    <p class="text-gray-600 mb-6">Prenez rendez-vous avec l'un de nos vétérinaires pour prendre soin de vos compagnons.</p>
                    <a href="{{ route('consultations.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors inline-flex items-center">
                        <x-heroicon-o-calendar class="w-5 h-5 mr-2" />
                        Prendre RDV
                    </a>
                </div>
                @endif

                <!-- Consultations urgentes -->
                @if($urgentConsultations->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-red-500">
                    <div class="p-6 border-b border-gray-200 bg-red-50">
                        <h2 class="text-xl font-semibold text-red-900">
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5 inline mr-2" /> 
                            Consultations Urgentes
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($urgentConsultations as $consultation)
                            <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-red-900">{{ $consultation->pet->name }} - {{ ucfirst($consultation->type) }}</h3>
                                        @php
                                            $date = \Carbon\Carbon::parse($consultation->scheduled_date);
                                            $time = \Carbon\Carbon::parse($consultation->scheduled_time);
                                        @endphp
                                        <p class="text-sm text-red-700">{{ $date->format('d/m/Y') }} à {{ $time->format('H\hi') }}</p>
                                    </div>
                                    <a href="{{ route('consultations.show', $consultation) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistiques mensuelles -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <x-heroicon-o-chart-bar class="w-5 h-5 inline mr-2" />
                        Ce mois-ci
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Consultations</span>
                            <span class="font-semibold text-gray-900">{{ $monthlyStats['total_consultations'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Urgences</span>
                            <span class="font-semibold text-red-600">{{ $monthlyStats['emergency_consultations'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Coût total</span>
                            <span class="font-semibold text-gray-900">{{ $monthlyStats['total_cost'] ?? 0 }} AED</span>
                        </div>
                        @if(isset($monthlyStats['average_satisfaction']) && $monthlyStats['average_satisfaction'])
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Satisfaction</span>
                            <div class="flex items-center">
                                <span class="font-semibold text-yellow-600">{{ number_format($monthlyStats['average_satisfaction'], 1) }}</span>
                                <x-heroicon-o-star class="w-4 h-4 text-yellow-500 ml-1" />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Services rapides -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <x-heroicon-o-bolt class="w-5 h-5 inline mr-2" />
                        Services rapides
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('consultations.create', ['type' => 'emergency']) }}" class="block p-3 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <x-heroicon-o-exclamation-triangle class="w-4 h-4 text-red-600" />
                                </div>
                                <div>
                                    <p class="font-medium text-red-900">Urgence</p>
                                    <p class="text-xs text-red-700">24/7 disponible</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('consultations.teleconsultation.create') }}" class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <x-heroicon-o-video-camera class="w-4 h-4 text-blue-600" />
                                </div>
                                <div>
                                    <p class="font-medium text-blue-900">Téléconsultation</p>
                                    <p class="text-xs text-blue-700">Dès 150 AED</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('consultations.create', ['type' => 'vaccination']) }}" class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <x-heroicon-o-shield-check class="w-4 h-4 text-green-600" />
                                </div>
                                <div>
                                    <p class="font-medium text-green-900">Vaccination</p>
                                    <p class="text-xs text-green-700">Protection complète</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Rappels pour vos animaux -->
                @if(auth()->user()->pets->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <x-heroicon-o-bell class="w-5 h-5 inline mr-2" />
                        Vos animaux
                    </h3>
                    <div class="space-y-3">
                        @foreach(auth()->user()->pets->take(3) as $pet)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                @if($pet->species === 'dog')
                                    🐕
                                @elseif($pet->species === 'cat')
                                    🐱
                                @else
                                    🐾
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $pet->name }}</p>
                                <p class="text-xs text-gray-600">{{ ucfirst($pet->species) }} • {{ $pet->breed ?? 'Race mixte' }}</p>
                            </div>
                            <a href="{{ route('consultations.create', ['pet_id' => $pet->id]) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                RDV
                            </a>
                        </div>
                        @endforeach
                        
                        @if(auth()->user()->pets->count() > 3)
                        <div class="text-center pt-2">
                            <a href="{{ route('pets.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                Voir tous mes animaux ({{ auth()->user()->pets->count() }})
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
