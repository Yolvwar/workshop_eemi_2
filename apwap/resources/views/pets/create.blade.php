@extends('layouts.app')

@section('title', 'Ajouter un animal')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Ajouter un Animal</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Enregistrez les informations de votre compagnon pour un suivi personnalisé
                    </p>
                </div>
                <a href="{{ route('pets.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                    Retour
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form method="POST" action="{{ route('pets.store') }}" class="space-y-8">
                    @csrf

                    <!-- Informations de base -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <span class="text-2xl">🐾</span>
                                Informations de base
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Les informations essentielles de votre animal</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'animal</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('name') border-red-300 @enderror" 
                                    placeholder="Ex: Max, Luna..." required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Espèce -->
                            <div>
                                <label for="species" class="block text-sm font-semibold text-gray-700 mb-2">Espèce</label>
                                <select name="species" id="species" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('species') border-red-300 @enderror">
                                    <option value="">Sélectionner une espèce</option>
                                    <option value="chien" @selected(old('species') == 'chien')>🐕 Chien</option>
                                    <option value="chat" @selected(old('species') == 'chat')>🐱 Chat</option>
                                </select>
                                @error('species') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Race -->
                            <div>
                                <label for="breed" class="block text-sm font-semibold text-gray-700 mb-2">Race</label>
                                <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('breed') border-red-300 @enderror"
                                    placeholder="Ex: Labrador, Persan...">
                                @error('breed') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date de naissance -->
                            <div>
                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">Date de naissance</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('birth_date') border-red-300 @enderror">
                                @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Sexe -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Sexe</label>
                                <select name="gender" id="gender"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('gender') border-red-300 @enderror">
                                    <option value="">Sélectionner le sexe</option>
                                    <option value="male" @selected(old('gender') == 'male')>♂ Mâle</option>
                                    <option value="female" @selected(old('gender') == 'female')>♀ Femelle</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Poids -->
                            <div>
                                <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">Poids (kg)</label>
                                <input type="number" step="0.1" min="0" name="weight" id="weight" value="{{ old('weight') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('weight') border-red-300 @enderror"
                                    placeholder="Ex: 25.5">
                                @error('weight') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Couleur -->
                            <div>
                                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">Couleur/Robe</label>
                                <input type="text" name="color" id="color" value="{{ old('color') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('color') border-red-300 @enderror"
                                    placeholder="Ex: Noir et blanc, Roux...">
                                @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Numéro de puce -->
                            <div>
                                <label for="microchip_number" class="block text-sm font-semibold text-gray-700 mb-2">Numéro de puce électronique</label>
                                <input type="text" name="microchip_number" id="microchip_number" value="{{ old('microchip_number') }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('microchip_number') border-red-300 @enderror"
                                    placeholder="Ex: 123456789012345">
                                @error('microchip_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Assurance -->
                        <div>
                            <label for="insurance_provider" class="block text-sm font-semibold text-gray-700 mb-2">Assurance santé (optionnel)</label>
                            <input type="text" name="insurance_provider" id="insurance_provider" value="{{ old('insurance_provider') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all @error('insurance_provider') border-red-300 @enderror"
                                placeholder="Ex: AXA, Allianz...">
                            @error('insurance_provider') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>


                    <!-- Scores des 6 piliers -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <span class="text-2xl">📊</span>
                                Évaluation initiale
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Scores de 0 à 100 pour chaque domaine (optionnel, peut être complété plus tard)</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @php
                                $pillars = [
                                    'health' => ['label' => 'Santé', 'icon' => '🏥', 'color' => 'emerald'],
                                    'education' => ['label' => 'Éducation', 'icon' => '🎓', 'color' => 'blue'],
                                    'nutrition' => ['label' => 'Nutrition', 'icon' => '🍽️', 'color' => 'orange'],
                                    'activity' => ['label' => 'Activité', 'icon' => '🏃', 'color' => 'purple'],
                                    'lifestyle' => ['label' => 'Lifestyle', 'icon' => '🏡', 'color' => 'pink'],
                                    'emotional' => ['label' => 'Émotionnel', 'icon' => '💙', 'color' => 'cyan']
                                ];
                            @endphp

                            @foreach ($pillars as $pillar => $info)
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <label for="{{ $pillar }}_score" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                        <span class="text-lg">{{ $info['icon'] }}</span>
                                        {{ $info['label'] }}
                                    </label>
                                    <input type="number" name="{{ $pillar }}_score" id="{{ $pillar }}_score" 
                                           min="0" max="100" value="{{ old($pillar . '_score') }}" 
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                                           placeholder="0-100">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dossier médical -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <span class="text-2xl">🏥</span>
                                Dossier médical
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Informations de santé et contacts vétérinaires (optionnel)</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Vétérinaire principal -->
                            <div class="md:col-span-2">
                                <label for="health_record[primary_vet_id]" class="block text-sm font-semibold text-gray-700 mb-2">Vétérinaire principal</label>
                                <select name="health_record[primary_vet_id]" id="health_record[primary_vet_id]"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all">
                                    <option value="">Sélectionner un vétérinaire</option>
                                    @foreach ($veterinarians as $vet)
                                        <option value="{{ $vet->id }}" @selected(old('health_record.primary_vet_id') == $vet->id)>
                                            {{ $vet->full_name }} — {{ $vet->clinic_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Groupe sanguin -->
                            <div>
                                <label for="health_record[blood_type]" class="block text-sm font-semibold text-gray-700 mb-2">Groupe sanguin</label>
                                <input type="text" name="health_record[blood_type]" id="health_record[blood_type]"
                                    value="{{ old('health_record.blood_type') }}" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                                    placeholder="Ex: A+, B-, O...">
                            </div>

                            <!-- Allergies -->
                            <div>
                                <label for="health_record[allergies]" class="block text-sm font-semibold text-gray-700 mb-2">Allergies connues</label>
                                <textarea name="health_record[allergies]" id="health_record[allergies]" rows="3"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all resize-none"
                                    placeholder="Listez les allergies connues...">{{ old('health_record.allergies') }}</textarea>
                            </div>

                            <!-- Médicaments -->
                            <div>
                                <label for="health_record[current_medications]" class="block text-sm font-semibold text-gray-700 mb-2">Médicaments en cours</label>
                                <textarea name="health_record[current_medications]" id="health_record[current_medications]" rows="3"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all resize-none"
                                    placeholder="Listez les traitements actuels...">{{ old('health_record.current_medications') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('pets.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-300 text-center">
                            Annuler
                        </a>
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <x-heroicon-o-plus-circle class="w-5 h-5" />
                            Ajouter l'animal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection