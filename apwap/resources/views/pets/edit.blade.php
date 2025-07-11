@extends('layouts.app')

@section('title', 'Modifier l\'animal')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">✏️ Modifier l'animal</h1>

        <form method="POST" action="{{ route('pets.update', $pet) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nom</label>
                <input type="text" id="name" name="name" value="{{ old('name', $pet->name) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="species" class="block text-gray-700 font-semibold mb-2">Espèce</label>
                <select name="species" id="species" required
                    class="w-full border px-4 py-2 rounded @error('species') border-red-500 @enderror">
                    <option value="chien" @selected(old('species', $pet->species ?? '') == 'chien')>Chien</option>
                    <option value="chat" @selected(old('species', $pet->species ?? '') == 'chat')>Chat</option>
                </select>

                @error('species')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="breed" class="block text-gray-700 font-semibold mb-2">Race</label>
                <input type="text" id="breed" name="breed" value="{{ old('breed', $pet->breed) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('breed') border-red-500 @enderror"
                    required>
                @error('breed')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="birth_date" class="block text-gray-700 font-semibold mb-2">Date de naissance</label>
                <input type="date" id="birth_date" name="birth_date"
                    value="{{ old('birth_date', $pet->birth_date ? $pet->birth_date->format('Y-m-d') : '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror">
                @error('birth_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-gray-700 font-semibold mb-2">Sexe</label>
                <select name="gender" id="gender" required
                    class="w-full border px-4 py-2 rounded @error('gender') border-red-500 @enderror">
                    <option value="male" @selected(old('gender', $pet->gender) == 'male')>Mâle</option>
                    <option value="female" @selected(old('gender', $pet->gender) == 'female')>Femelle</option>
                </select>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="is_neutered" class="inline-flex items-center gap-2">
                    <input type="hidden" name="is_neutered" value="0">
                    <input type="checkbox" id="is_neutered" name="is_neutered" value="1" @checked(old('is_neutered', $pet->is_neutered))>
                    Castré / Stérilisé
                </label>
            </div>

            <div class="mb-4">
                <label for="weight" class="block text-gray-700 font-semibold mb-2">Poids (kg)</label>
                <input type="number" step="0.1" id="weight" name="weight" value="{{ old('weight', $pet->weight) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="color" class="block text-gray-700 font-semibold mb-2">Couleur</label>
                <input type="text" id="color" name="color" value="{{ old('color', $pet->color) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <hr class="my-6 border-t">

            <h2 class="text-xl font-bold text-gray-800 mb-4">🏥 Santé & Médical</h2>

            <div class="mb-4">
                <label for="primary_vet_id" class="block text-gray-700 font-semibold mb-2">
                    Vétérinaire principal
                </label>

                <select name="health_record[primary_vet_name]" id="primary_vet_name"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Sélectionnez un vétérinaire —</option>
                    @foreach ($veterinarians as $vet)
                        <option value="{{ $vet->full_name }}" @selected(old('health_record.primary_vet_name', $pet->healthRecord->primary_vet_name ?? '') == $vet->full_name)>
                            {{ $vet->full_name }} — {{ $vet->clinic_name }}
                        </option>
                    @endforeach
                </select>


            </div>

            <div class="mb-4">
                <label for="blood_type" class="block text-gray-700 font-semibold mb-2">Groupe sanguin</label>
                <input type="text" id="blood_type" name="health_record[blood_type]"
                    value="{{ old('health_record.blood_type', $pet->healthRecord->blood_type ?? '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="allergies" class="block text-gray-700 font-semibold mb-2">Allergies</label>
                <textarea id="allergies" name="health_record[allergies]" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('health_record.allergies', $pet->healthRecord->allergies ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="current_medications" class="block text-gray-700 font-semibold mb-2">Médicaments en cours</label>
                <textarea id="current_medications" name="health_record[current_medications]" rows="3"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('health_record.current_medications', $pet->healthRecord->current_medications ?? '') }}</textarea>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">📊 Scores de suivi</h2>

            @foreach(['health', 'education', 'nutrition', 'activity', 'lifestyle', 'emotional'] as $score)
                <div class="mb-4">
                    <label for="{{ $score }}_score" class="block text-gray-700 font-semibold mb-2">
                        {{ ucfirst($score) }} (0–100)
                    </label>
                    <input type="number" id="{{ $score }}_score" name="{{ $score }}_score"
                        value="{{ old($score . '_score', $pet[$score . '_score']) }}" min="0" max="100"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            @endforeach

            <div class="flex justify-end gap-3">
                <a href="{{ route('pets.index') }}"
                    class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection