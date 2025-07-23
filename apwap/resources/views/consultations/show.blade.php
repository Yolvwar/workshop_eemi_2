@extends('layouts.app')

@section('title', 'Consultation #' . substr($consultation->id, 0, 8))

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
                <x-heroicon-o-check-circle class="w-5 h-5 inline mr-2" />
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900">
                            <x-heroicon-o-calendar-days class="w-8 h-8 inline mr-3" />
                            Consultation #{{ substr($consultation->id, 0, 8) }}
                        </h1>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($consultation->status === 'scheduled') bg-blue-100 text-blue-800
                            @elseif($consultation->status === 'in_progress') bg-yellow-100 text-yellow-800
                            @elseif($consultation->status === 'completed') bg-green-100 text-green-800
                            @elseif($consultation->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($consultation->status === 'scheduled') 
                                <x-heroicon-o-clock class="w-4 h-4 inline mr-1" /> Programmée
                            @elseif($consultation->status === 'in_progress') 
                                <x-heroicon-o-play class="w-4 h-4 inline mr-1" /> En cours
                            @elseif($consultation->status === 'completed') 
                                <x-heroicon-o-check-circle class="w-4 h-4 inline mr-1" /> Terminée
                            @elseif($consultation->status === 'cancelled') 
                                <x-heroicon-o-x-circle class="w-4 h-4 inline mr-1" /> Annulée
                            @else 
                                {{ ucfirst($consultation->status) }}
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-600">
                        @php
                            $date = \Carbon\Carbon::parse($consultation->scheduled_date);
                            $time = \Carbon\Carbon::parse($consultation->scheduled_time);
                        @endphp
                        Programmée le {{ $date->format('l j F Y') }} à {{ $time->format('H\hi') }}
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    @if($consultation->status === 'scheduled')
                        <a href="{{ route('consultations.edit', $consultation) }}" 
                           class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                            <x-heroicon-o-pencil class="w-4 h-4 inline mr-2" /> Modifier
                        </a>
                        @if($consultation->mode === 'teleconsultation')
                            <a href="{{ route('consultations.teleconsultation', $consultation) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                <x-heroicon-o-video-camera class="w-4 h-4 inline mr-2" /> Rejoindre
                            </a>
                        @endif
                    @endif
                    
                    <a href="{{ route('consultations.index') }}" 
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        ← Retour aux consultations
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations de la consultation -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <x-heroicon-o-document-text class="w-5 h-5 inline mr-2" />
                            Informations de consultation
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Animal -->
                            <div class="flex items-center space-x-4 p-4 bg-emerald-50 rounded-xl">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    @if($consultation->pet->species === 'dog')
                                        🐕
                                    @elseif($consultation->pet->species === 'cat')
                                        🐱
                                    @else
                                        🐾
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $consultation->pet->name }}</p>
                                    <p class="text-sm text-gray-600">{{ ucfirst($consultation->pet->species) }} • {{ $consultation->pet->breed ?? 'Race mixte' }}</p>
                                </div>
                            </div>

                            <!-- Vétérinaire -->
                            <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-xl">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-user-circle class="w-6 h-6 text-blue-600" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Dr. {{ $consultation->veterinarian->first_name }} {{ $consultation->veterinarian->last_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $consultation->veterinarian->specializations ?? 'Vétérinaire généraliste' }}</p>
                                </div>
                            </div>

                            <!-- Type de consultation -->
                            <div class="flex items-center space-x-4 p-4 bg-purple-50 rounded-xl">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-purple-600" />
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $consultation->type)) }}</p>
                                    <p class="text-sm text-gray-600">Priorité: {{ ucfirst($consultation->urgency_level) }}</p>
                                </div>
                            </div>

                            <!-- Mode -->
                            <div class="flex items-center space-x-4 p-4 bg-orange-50 rounded-xl">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    @if($consultation->mode === 'in_clinic')
                                        <x-heroicon-o-building-office class="w-6 h-6 text-orange-600" />
                                    @elseif($consultation->mode === 'home_visit')
                                        <x-heroicon-o-home class="w-6 h-6 text-orange-600" />
                                    @else
                                        <x-heroicon-o-video-camera class="w-6 h-6 text-orange-600" />
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        @if($consultation->mode === 'in_clinic') En clinique
                                        @elseif($consultation->mode === 'home_visit') À domicile
                                        @else Téléconsultation
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $consultation->total_price }} AED</p>
                                </div>
                            </div>
                        </div>

                        <!-- Symptômes -->
                        @if($consultation->symptoms_description)
                        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-medium text-gray-900 mb-2">
                                <x-heroicon-o-chat-bubble-left-ellipsis class="w-4 h-4 inline mr-1" />
                                Symptômes décrits
                            </h3>
                            <p class="text-gray-700">{{ $consultation->symptoms_description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <x-heroicon-o-document-plus class="w-5 h-5 inline mr-2" />
                            Informations supplémentaires
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Documents -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                                <x-heroicon-o-folder class="w-4 h-4 mr-2" />
                                Documents
                            </h4>
                            <div class="space-y-2">
                                @foreach($additionalInfo['documents'] as $key => $label)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                    <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <x-heroicon-o-plus class="w-4 h-4 inline mr-1" />
                                        Ajouter
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Questionnaire -->
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                                <x-heroicon-o-clipboard-document-list class="w-4 h-4 mr-2" />
                                Questionnaire
                            </h4>
                            <div class="space-y-2">
                                @foreach($additionalInfo['questionnaire'] as $key => $label)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                    <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <x-heroicon-o-pencil class="w-4 h-4 inline mr-1" />
                                        Remplir
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Médias -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                                <x-heroicon-o-camera class="w-4 h-4 mr-2" />
                                Médias
                            </h4>
                            <div class="space-y-2">
                                @foreach($additionalInfo['media'] as $key => $label)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                    <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        <x-heroicon-o-photo class="w-4 h-4 inline mr-1" />
                                        Télécharger
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bouton d'action principale -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="{{ route('consultations.prepare', $consultation) }}" 
                               class="w-full bg-emerald-600 text-white px-4 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors text-center block">
                                <x-heroicon-o-document-check class="w-5 h-5 inline mr-2" />
                                Compléter les informations
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notes vétérinaire -->
                @if($consultation->veterinarian_notes)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <x-heroicon-o-document-text class="w-5 h-5 inline mr-2" />
                            Notes du vétérinaire
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-gray-700 leading-relaxed">{{ $consultation->veterinarian_notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Diagnostic et traitement -->
                @if($consultation->diagnosis || $consultation->treatment_plan)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <x-heroicon-o-clipboard-document-check class="w-5 h-5 inline mr-2" />
                            Diagnostic et traitement
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($consultation->diagnosis)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Diagnostic</h4>
                            <div class="bg-green-50 rounded-xl p-4">
                                <p class="text-gray-700">{{ $consultation->diagnosis }}</p>
                            </div>
                        </div>
                        @endif

                        @if($consultation->treatment_plan)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Plan de traitement</h4>
                            <div class="bg-purple-50 rounded-xl p-4">
                                <p class="text-gray-700">{{ $consultation->treatment_plan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Informations rapides -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <x-heroicon-o-information-circle class="w-5 h-5 inline mr-2" />
                            Informations rapides
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Date de création</span>
                            <span class="font-medium">{{ $consultation->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Durée estimée</span>
                            <span class="font-medium">45 min</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Prix total</span>
                            <span class="font-bold text-emerald-600">{{ $consultation->total_price }} AED</span>
                        </div>
                        @if($consultation->next_appointment_date)
                        <div class="pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Prochain RDV</span>
                            <p class="font-medium text-blue-600">{{ \Carbon\Carbon::parse($consultation->next_appointment_date)->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <x-heroicon-o-cog-6-tooth class="w-5 h-5 inline mr-2" />
                            Actions
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($consultation->status === 'scheduled')
                            <a href="{{ route('consultations.edit', $consultation) }}" 
                               class="w-full bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors text-center block">
                                <x-heroicon-o-pencil class="w-4 h-4 inline mr-2" /> Modifier
                            </a>
                            @if($consultation->mode === 'teleconsultation')
                                <a href="{{ route('consultations.teleconsultation', $consultation) }}" 
                                   class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center block">
                                    <x-heroicon-o-video-camera class="w-4 h-4 inline mr-2" /> Rejoindre
                                </a>
                            @endif
                            <form action="{{ route('consultations.cancel', $consultation) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette consultation ?')">
                                    <x-heroicon-o-x-circle class="w-4 h-4 inline mr-2" /> Annuler
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('consultations.index') }}" 
                           class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center block">
                            ← Retour aux consultations
                        </a>
                    </div>
                </div>

                <!-- Contact vétérinaire -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <x-heroicon-o-phone class="w-5 h-5 inline mr-2" />
                            Contact vétérinaire
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <x-heroicon-o-user-circle class="w-5 h-5 text-blue-600" />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Dr. {{ $consultation->veterinarian->first_name }} {{ $consultation->veterinarian->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $consultation->veterinarian->specializations ?? 'Généraliste' }}</p>
                            </div>
                        </div>
                        
                        @if($consultation->status === 'scheduled' || $consultation->status === 'in_progress')
                        <div class="space-y-2">
                            <a href="tel:+971-4-xxx-xxxx" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors text-center block text-sm">
                                <x-heroicon-o-phone class="w-4 h-4 inline mr-2" /> Appeler
                            </a>
                            <a href="mailto:{{ $consultation->veterinarian->email ?? 'vet@apwap.com' }}" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center block text-sm">
                                <x-heroicon-o-envelope class="w-4 h-4 inline mr-2" /> Email
                            </a>
                        </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
