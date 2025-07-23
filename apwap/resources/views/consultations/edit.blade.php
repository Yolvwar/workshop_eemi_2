@extends('layouts.app')

@section('title', 'Modifier le Rendez-vous - APWAP')
@section('page-title', 'Modifier le Rendez-vous')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <x-heroicon-o-pencil class="w-8 h-8 inline mr-3" />
                        Modifier le Rendez-vous
                    </h1>
                    <p class="text-gray-600 mt-2">Modifiez les détails de votre consultation</p>
                </div>
                <a href="{{ route('consultations.show', $consultation) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    ← Retour à la consultation
                </a>
            </div>
        </div>

        <form action="{{ route('consultations.update', $consultation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

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
                                <div class="border-2 rounded-xl p-4 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer pet-card 
                                            {{ $consultation->pet_id === $pet->id ? 'border-emerald-500 bg-emerald-50' : 'border-gray-200' }}" 
                                     data-pet-id="{{ $pet->id }}">
                                    <input type="radio" name="pet_id" value="{{ $pet->id }}" class="hidden pet-radio" 
                                           {{ $consultation->pet_id === $pet->id ? 'checked' : '' }}>
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @error('pet_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                @endif
            </div>
        </div>

        <!-- Étape 2: Type de Consultation -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">🎯 Type de Consultation <span class="text-sm text-gray-500">[Étape 2/4]</span></h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($consultationTypes as $key => $type)
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors cursor-pointer consultation-type-card 
                                    {{ $consultation->type === $key ? 'border-blue-500 bg-blue-50' : '' }}" 
                             data-type="{{ $key }}">
                            <input type="radio" name="type" value="{{ $key }}" class="hidden consultation-type-radio"
                                   {{ $consultation->type === $key ? 'checked' : '' }}>
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        @switch($key)
                                            @case('general') 🏥 @break
                                            @case('vaccination') 💉 @break
                                            @case('dental') 🦷 @break
                                            @case('analysis') 🔬 @break
                                            @case('behavior') 🎓 @break
                                            @case('emergency') 🚨 @break
                                            @case('teleconsultation') 💻 @break
                                        @endswitch
                                        {{ $type['name'] }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">({{ $type['duration'] }}min)</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ $type['price'] }} AED</p>
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

        <!-- Étape 3: Mode et Planning -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">📍 Mode et Planning <span class="text-sm text-gray-500">[Étape 3/4]</span></h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Mode de consultation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Mode de consultation</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors cursor-pointer mode-card
                                    {{ $consultation->mode === 'in_clinic' ? 'border-blue-500 bg-blue-50' : '' }}" 
                             data-mode="in_clinic">
                            <input type="radio" name="mode" value="in_clinic" class="hidden mode-radio"
                                   {{ $consultation->mode === 'in_clinic' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="text-3xl mb-2">🏥</div>
                                <h3 class="font-semibold">En clinique</h3>
                                <p class="text-sm text-gray-600">Rendez-vous à la clinique</p>
                            </div>
                        </div>
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors cursor-pointer mode-card
                                    {{ $consultation->mode === 'home_visit' ? 'border-blue-500 bg-blue-50' : '' }}" 
                             data-mode="home_visit">
                            <input type="radio" name="mode" value="home_visit" class="hidden mode-radio"
                                   {{ $consultation->mode === 'home_visit' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="text-3xl mb-2">🏠</div>
                                <h3 class="font-semibold">À domicile</h3>
                                <p class="text-sm text-gray-600">Visite chez vous (+100 AED)</p>
                            </div>
                        </div>
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors cursor-pointer mode-card
                                    {{ $consultation->mode === 'teleconsultation' ? 'border-blue-500 bg-blue-50' : '' }}" 
                             data-mode="teleconsultation">
                            <input type="radio" name="mode" value="teleconsultation" class="hidden mode-radio"
                                   {{ $consultation->mode === 'teleconsultation' ? 'checked' : '' }}>
                            <div class="text-center">
                                <div class="text-3xl mb-2">💻</div>
                                <h3 class="font-semibold">Téléconsultation</h3>
                                <p class="text-sm text-gray-600">Consultation en ligne</p>
                            </div>
                        </div>
                    </div>
                    @error('mode')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date et heure -->
                <div>
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">
                        📅 Date et heure du rendez-vous
                    </label>
                    <input type="datetime-local" 
                           id="scheduled_at" 
                           name="scheduled_at" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ $consultation->scheduled_at->format('Y-m-d\TH:i') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}">
                    @error('scheduled_at')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vétérinaire -->
                <div>
                    <label for="veterinarian_id" class="block text-sm font-medium text-gray-700 mb-2">
                        👨‍⚕️ Vétérinaire préféré (optionnel)
                    </label>
                    <select name="veterinarian_id" id="veterinarian_id" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Assignation automatique</option>
                        @foreach($veterinarians as $vet)
                            <option value="{{ $vet->id }}" {{ $consultation->veterinarian_id === $vet->id ? 'selected' : '' }}>
                                {{ $vet->name }} - {{ $vet->specializations }} (⭐ {{ $vet->rating }}/5)
                            </option>
                        @endforeach
                    </select>
                    @error('veterinarian_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Étape 4: Détails -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">📝 Détails <span class="text-sm text-gray-500">[Étape 4/4]</span></h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Niveau d'urgence -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Niveau d'urgence</label>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @php
                            $urgencyLevels = [
                                'low' => ['name' => 'Faible', 'color' => 'green', 'icon' => '😌'],
                                'medium' => ['name' => 'Moyen', 'color' => 'yellow', 'icon' => '🤔'],
                                'high' => ['name' => 'Élevé', 'color' => 'orange', 'icon' => '😰'],
                                'urgent' => ['name' => 'Urgent', 'color' => 'red', 'icon' => '😱'],
                                'emergency' => ['name' => 'Urgence', 'color' => 'red', 'icon' => '🚨']
                            ];
                        @endphp
                        @foreach($urgencyLevels as $level => $info)
                            <div class="border-2 border-gray-200 rounded-lg p-3 hover:border-{{ $info['color'] }}-500 transition-colors cursor-pointer urgency-card
                                        {{ $consultation->priority === $level ? 'border-'.$info['color'].'-500 bg-'.$info['color'].'-50' : '' }}" 
                                 data-urgency="{{ $level }}">
                                <input type="radio" name="urgency_level" value="{{ $level }}" class="hidden urgency-radio"
                                       {{ $consultation->priority === $level ? 'checked' : '' }}>
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $info['icon'] }}</div>
                                    <div class="text-sm font-medium">{{ $info['name'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('urgency_level')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description des symptômes -->
                <div>
                    <label for="symptoms_description" class="block text-sm font-medium text-gray-700 mb-2">
                        🩺 Description des symptômes (optionnel)
                    </label>
                    <textarea name="symptoms_description" 
                              id="symptoms_description" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Décrivez les symptômes observés, comportements inhabituels, etc.">{{ old('symptoms_description', $consultation->symptoms) }}</textarea>
                    @error('symptoms_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex space-x-4">
            <button type="submit" 
                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                💾 Sauvegarder les modifications
            </button>
            <a href="{{ route('consultations.show', $consultation) }}" 
               class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors font-medium text-center">
                ❌ Annuler
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pet-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.pet-card').forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50');
                c.classList.add('border-gray-200');
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-blue-500', 'bg-blue-50');
            this.querySelector('.pet-radio').checked = true;
        });
    });

    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.consultation-type-card').forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50');
                c.classList.add('border-gray-200');
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-blue-500', 'bg-blue-50');
            this.querySelector('.consultation-type-radio').checked = true;
        });
    });

    document.querySelectorAll('.mode-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.mode-card').forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50');
                c.classList.add('border-gray-200');
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-blue-500', 'bg-blue-50');
            this.querySelector('.mode-radio').checked = true;
        });
    });

    document.querySelectorAll('.urgency-card').forEach(card => {
        card.addEventListener('click', function() {
            const urgency = this.dataset.urgency;
            document.querySelectorAll('.urgency-card').forEach(c => {
                c.className = c.className.replace(/border-\w+-500|bg-\w+-50/g, '');
                c.classList.add('border-gray-200');
            });
            
            const colors = {
                'low': 'green',
                'medium': 'yellow', 
                'high': 'orange',
                'urgent': 'red',
                'emergency': 'red'
            };
            
            const color = colors[urgency];
            this.classList.remove('border-gray-200');
            this.classList.add(`border-${color}-500`, `bg-${color}-50`);
            this.querySelector('.urgency-radio').checked = true;
        });
    });
});
</script>
@endsection
