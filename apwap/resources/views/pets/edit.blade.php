@extends('layouts.app')

@section('title', 'Modifier ' . $pet->name)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                <x-heroicon-o-pencil-square class="w-8 h-8 text-emerald-600" />
                Modifier {{ $pet->name }}
            </h1>
            <a href="{{ route('pets.show', $pet) }}" 
               class="inline-flex items-center text-gray-600 hover:text-emerald-600 transition-colors duration-200">
                <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />
                Retour au profil
            </a>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-2xl shadow-lg px-8 py-6">
            <form method="POST" action="{{ route('pets.update', $pet) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Informations de base -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                        <x-heroicon-o-identification class="w-6 h-6 text-emerald-600" />
                        Informations générales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $pet->name) }}"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Espèce -->
                        <div>
                            <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Espèce</label>
                            <select name="species" id="species" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                                <option value="chien" @selected(old('species', $pet->species) == 'chien')>Chien</option>
                                <option value="chat" @selected(old('species', $pet->species) == 'chat')>Chat</option>
                            </select>
                        </div>

                        <!-- Race -->
                        <div>
                            <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Race</label>
                            <input type="text" id="breed" name="breed" value="{{ old('breed', $pet->breed) }}"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <!-- Date de naissance -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                            <input type="date" id="birth_date" name="birth_date"
                                value="{{ old('birth_date', $pet->birth_date?->format('Y-m-d')) }}"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <!-- Genre -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Sexe</label>
                            <select name="gender" id="gender" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                                <option value="male" @selected(old('gender', $pet->gender) == 'male')>Mâle</option>
                                <option value="female" @selected(old('gender', $pet->gender) == 'female')>Femelle</option>
                            </select>
                        </div>

                        <div>
    <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
    <input type="number" 
           step="any" 
           id="weight" 
           name="weight" 
           value="{{ old('weight', $pet->weight) }}"
           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
</div>
                    </div>

                    <!-- Castré/Stérilisé -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_neutered" name="is_neutered" value="1" 
                            @checked(old('is_neutered', $pet->is_neutered))
                            class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <label for="is_neutered" class="text-sm text-gray-700">Castré / Stérilisé</label>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('pets.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-200">
                        <x-heroicon-o-x-mark class="w-5 h-5 mr-2" />
                        Annuler
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors duration-200">
                        <x-heroicon-o-check class="w-5 h-5 mr-2" />
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection