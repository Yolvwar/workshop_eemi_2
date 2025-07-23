@extends('layouts.app')

@section('title', 'Nouveau Rendez-vous - APWAP')
@section('page-title', 'Nouveau Rendez-vous')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <x-heroicon-o-calendar class="w-8 h-8 inline mr-3" />
                        Nouveau Rendez-vous
                    </h1>
                    <p class="text-gray-600 mt-2">Prenez rendez-vous avec l'un de nos vétérinaires experts</p>
                </div>
                <a href="{{ route('consultations.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    ← Retour aux consultations
                </a>
            </div>
        </div>

        <form action="{{ route('consultations.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Étape 1: Sélection Animal -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-heart class="w-5 h-5 inline mr-2" />
                        Sélection Animal 
                        <span class="text-sm font-normal text-gray-500">[Étape 1/4]</span>
                    </h2>
                </div>
                <div class="p-6">
                    @if($pets->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($pets as $pet)
                                <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer pet-card" 
                                     data-pet-id="{{ $pet->id }}">
                                    <input type="radio" name="pet_id" value="{{ $pet->id }}" class="hidden pet-radio" 
                                           @if($selectedPet && $selectedPet->id === $pet->id) checked @endif>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            @if($pet->species === 'dog')
                                                🐕
                                            @elseif($pet->species === 'cat')
                                                🐱
                                            @else
                                                🐾
                                            @endif
                                        </div>
                                        <h3 class="font-semibold text-gray-900">{{ $pet->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ ucfirst($pet->breed ?? 'Race mixte') }}</p>
                                        <p class="text-gray-500 text-xs mt-2">
                                            Dernière visite: {{ $pet->last_consultation_date ?? 'Jamais' }}
                                        </p>
                                        @if($pet->recommended_consultation)
                                            <div class="mt-2 text-xs bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full">
                                                🎯 Recommandé: {{ $pet->recommended_consultation }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <x-heroicon-o-heart class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun animal enregistré</h3>
                            <p class="text-gray-600 mb-6">Vous devez d'abord enregistrer un animal pour prendre rendez-vous.</p>
                            <a href="{{ route('pets.index') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors inline-flex items-center">
                                <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                                Ajouter un animal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Étape 2: Type de Consultation -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5 inline mr-2" />
                        Type de Consultation 
                        <span class="text-sm font-normal text-gray-500">[Étape 2/4]</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($consultationTypes as $key => $type)
                            <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer consultation-type-card" 
                                 data-type="{{ $key }}">
                                <input type="radio" name="type" value="{{ $key }}" class="hidden consultation-type-radio">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            @switch($key)
                                                @case('general') 
                                                    <x-heroicon-o-clipboard-document-check class="w-5 h-5 text-gray-600" />
                                                    @break
                                                @case('vaccination') 
                                                    <x-heroicon-o-shield-check class="w-5 h-5 text-green-600" />
                                                    @break
                                                @case('dental') 
                                                    <x-heroicon-o-face-smile class="w-5 h-5 text-blue-600" />
                                                    @break
                                                @case('analysis') 
                                                    <x-heroicon-o-beaker class="w-5 h-5 text-purple-600" />
                                                    @break
                                                @case('behavior') 
                                                    <x-heroicon-o-academic-cap class="w-5 h-5 text-indigo-600" />
                                                    @break
                                                @case('emergency') 
                                                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-600" />
                                                    @break
                                            @endswitch
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $type['name'] }}</h3>
                                            <p class="text-gray-600 text-sm">Durée: {{ $type['duration'] }} min</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-emerald-600 text-lg">{{ $type['price'] }} AED</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Étape 3: Lieu & Mode -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-map-pin class="w-5 h-5 inline mr-2" />
                        Lieu & Mode 
                        <span class="text-sm font-normal text-gray-500">[Étape 3/4]</span>
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer mode-card" 
                             data-mode="in_clinic">
                            <input type="radio" name="mode" value="in_clinic" class="hidden mode-radio" checked>
                            <div class="text-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-building-office class="w-6 h-6 text-emerald-600" />
                                </div>
                                <h3 class="font-semibold text-gray-900">En clinique</h3>
                                <p class="text-gray-600 text-sm">Tarif standard</p>
                                <p class="text-gray-500 text-xs mt-2">
                                    APWAP Clinic JLT<br>
                                    Équipement complet
                                </p>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer mode-card" 
                             data-mode="home_visit">
                            <input type="radio" name="mode" value="home_visit" class="hidden mode-radio">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-home class="w-6 h-6 text-blue-600" />
                                </div>
                                <h3 class="font-semibold text-gray-900">À domicile</h3>
                                <p class="text-gray-600 text-sm">+100 AED</p>
                                <p class="text-gray-500 text-xs mt-2">
                                    Confort de votre foyer<br>
                                    Sur rendez-vous
                                </p>
                            </div>
                        </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 transition-all cursor-pointer mode-card mode-card-teleconsultation" 
                             data-mode="teleconsultation">
                            <input type="radio" name="mode" value="teleconsultation" class="hidden mode-radio">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-video-camera class="w-6 h-6 text-purple-600" />
                                </div>
                                <h3 class="font-semibold text-gray-900">Téléconsultation</h3>
                                <p class="text-gray-600 text-sm">-50% sur le tarif</p>
                                <p class="text-gray-500 text-xs mt-2">
                                    Consultation vidéo<br>
                                    24/7 disponible
                                </p>
                                <div class="mt-2 text-xs text-red-600 hidden teleconsultation-warning">
                                    Non disponible pour ce type de consultation
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('mode')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Étape 4: Date et Vétérinaire -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-calendar class="w-5 h-5 inline mr-2" />
                        Date et Vétérinaire 
                        <span class="text-sm font-normal text-gray-500">[Étape 4/4]</span>
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Date et heure -->
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">
                            <x-heroicon-o-clock class="w-4 h-4 inline mr-1" />
                            Date et heure souhaitées
                        </label>
                        <input type="datetime-local" 
                               id="scheduled_at" 
                               name="scheduled_at" 
                               min="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}"
                               class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                               value="{{ old('scheduled_at') }}">
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sélection vétérinaire -->
                    <div>
                        <label for="veterinarian_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <x-heroicon-o-user-circle class="w-4 h-4 inline mr-1" />
                            Vétérinaire préféré (optionnel)
                        </label>
                        <select name="veterinarian_id" id="veterinarian_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Laisser APWAP choisir le meilleur vétérinaire</option>
                            @foreach($veterinarians as $vet)
                                <option value="{{ $vet->id }}" {{ old('veterinarian_id') == $vet->id ? 'selected' : '' }}>
                                    Dr. {{ $vet->first_name }} {{ $vet->last_name }} - {{ $vet->specializations ?? 'Généraliste' }} ({{ $vet->consultation_fee ?? '300' }} AED)
                                </option>
                            @endforeach
                        </select>
                        @error('veterinarian_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Niveau d'urgence -->
                    <div>
                        <label for="urgency_level" class="block text-sm font-medium text-gray-700 mb-2">
                            <x-heroicon-o-exclamation-triangle class="w-4 h-4 inline mr-1" />
                            Niveau d'urgence
                        </label>
                        <select name="urgency_level" id="urgency_level" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="low" {{ old('urgency_level') == 'low' ? 'selected' : '' }}>🟢 Faible - Contrôle de routine</option>
                            <option value="medium" {{ old('urgency_level', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Moyen - Consultation standard</option>
                            <option value="high" {{ old('urgency_level') == 'high' ? 'selected' : '' }}>🟠 Élevé - Nécessite attention rapide</option>
                            <option value="urgent" {{ old('urgency_level') == 'urgent' ? 'selected' : '' }}>🔴 Urgent - Dans les 24h</option>
                            <option value="emergency" {{ old('urgency_level') == 'emergency' ? 'selected' : '' }}>🚨 Urgence - Immédiat</option>
                        </select>
                        @error('urgency_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description des symptômes -->
                    <div>
                        <label for="symptoms_description" class="block text-sm font-medium text-gray-700 mb-2">
                            <x-heroicon-o-chat-bubble-left-ellipsis class="w-4 h-4 inline mr-1" />
                            Description des symptômes (optionnel)
                        </label>
                        <textarea name="symptoms_description" 
                                  id="symptoms_description" 
                                  rows="4" 
                                  class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Décrivez les symptômes observés, le comportement de votre animal, etc.">{{ old('symptoms_description') }}</textarea>
                        @error('symptoms_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="text-left">
                        <p class="text-sm text-gray-600">Coût estimé: <span id="estimated-cost" class="font-semibold text-emerald-600">300 AED</span></p>
                        <p class="text-xs text-gray-500">Le coût final peut varier selon les soins nécessaires</p>
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('consultations.index') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors flex items-center">
                            <x-heroicon-o-calendar class="w-5 h-5 mr-2" />
                            Confirmer le rendez-vous
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let consultationTypes = {};
    try {
        consultationTypes = {!! json_encode($consultationTypes ?? []) !!};
    } catch (e) {
        console.warn('Types de consultation non disponibles');
    }

    document.querySelectorAll('.pet-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.pet-card').forEach(c => {
                c.classList.remove('border-emerald-500', 'bg-emerald-50');
            });
            this.classList.add('border-emerald-500', 'bg-emerald-50');
            this.querySelector('.pet-radio').checked = true;
            updateEstimatedCost();
        });
    });

    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.consultation-type-card').forEach(c => {
                c.classList.remove('border-emerald-500', 'bg-emerald-50');
            });
            this.classList.add('border-emerald-500', 'bg-emerald-50');
            this.querySelector('.consultation-type-radio').checked = true;
            
            const selectedType = this.querySelector('.consultation-type-radio').value;
            const teleconsultationCard = document.querySelector('.mode-card-teleconsultation');
            const teleconsultationWarning = document.querySelector('.teleconsultation-warning');
            const teleconsultationRadio = teleconsultationCard.querySelector('.mode-radio');
            
            const restrictedTypes = ['general', 'vaccination', 'dental', 'analysis'];
            
            if (restrictedTypes.includes(selectedType)) {
                teleconsultationCard.classList.add('opacity-50', 'cursor-not-allowed');
                teleconsultationCard.classList.remove('hover:border-emerald-500', 'hover:shadow-md', 'cursor-pointer');
                teleconsultationWarning.classList.remove('hidden');
                teleconsultationRadio.disabled = true;
                
                if (teleconsultationRadio.checked) {
                    teleconsultationRadio.checked = false;
                    teleconsultationCard.classList.remove('border-emerald-500', 'bg-emerald-50');
                    
                    const clinicCard = document.querySelector('[data-mode="in_clinic"]');
                    if (clinicCard) {
                        clinicCard.classList.add('border-emerald-500', 'bg-emerald-50');
                        clinicCard.querySelector('.mode-radio').checked = true;
                    }
                }
            } else {
                teleconsultationCard.classList.remove('opacity-50', 'cursor-not-allowed');
                teleconsultationCard.classList.add('hover:border-emerald-500', 'hover:shadow-md', 'cursor-pointer');
                teleconsultationWarning.classList.add('hidden');
                teleconsultationRadio.disabled = false;
            }
            
            updateEstimatedCost();
        });
    });

    document.querySelectorAll('.mode-card').forEach(card => {
        card.addEventListener('click', function() {
            if (this.classList.contains('mode-card-teleconsultation') && 
                this.querySelector('.mode-radio').disabled) {
                return;
            }
            
            document.querySelectorAll('.mode-card').forEach(c => {
                c.classList.remove('border-emerald-500', 'bg-emerald-50');
            });
            this.classList.add('border-emerald-500', 'bg-emerald-50');
            this.querySelector('.mode-radio').checked = true;
            updateEstimatedCost();
        });
    });

    function updateEstimatedCost() {
        const typeInput = document.querySelector('.consultation-type-radio:checked');
        const modeInput = document.querySelector('.mode-radio:checked');
        const costElement = document.getElementById('estimated-cost');
        
        if (typeInput && modeInput && costElement) {
            let basePrice = 300;
            
            if (consultationTypes[typeInput.value]) {
                basePrice = consultationTypes[typeInput.value].price || 300;
            }
            
            let totalPrice = basePrice;
            
            if (modeInput.value === 'home_visit') {
                totalPrice += 100;
            } else if (modeInput.value === 'teleconsultation') {
                totalPrice = Math.floor(basePrice * 0.5);
            }
            
            costElement.textContent = totalPrice + ' AED';
        }
    }

    const scheduledInput = document.getElementById('scheduled_at');
    if (scheduledInput) {
        scheduledInput.addEventListener('change', updateEstimatedCost);
    }
    
    updateEstimatedCost();
});
</script>
@endsection
