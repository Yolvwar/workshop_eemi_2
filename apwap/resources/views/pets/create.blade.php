@extends('layouts.app')

@section('title', 'Ajouter un animal')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Ajouter un animal</h1>

        <form method="POST" action="{{ route('pets.store') }}" class="space-y-5">
            @csrf

            {{-- Infos de base --}}
            <div>
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-1">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border px-4 py-2 rounded @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="species" class="block text-gray-700 font-medium mb-1">Espèce</label>
                    <select name="species" id="species" required
                        class="w-full border px-4 py-2 rounded @error('species') border-red-500 @enderror">
                        <option value="">-- Sélectionner --</option>
                        <option value="chien" @selected(old('species') == 'chien')>Chien</option>
                        <option value="chat" @selected(old('species') == 'chat')>Chat</option>
                    </select>

                    @error('species') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="breed" class="block text-gray-700 font-medium mb-1">Race</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                        class="w-full border px-4 py-2 rounded @error('breed') border-red-500 @enderror">
                    @error('breed') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="birth_date" class="block text-gray-700 font-medium mb-1">Date de naissance</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                        class="w-full border px-4 py-2 rounded @error('birth_date') border-red-500 @enderror">
                    @error('birth_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="gender" class="block text-gray-700 font-medium mb-1">Sexe</label>
                    <select name="gender" id="gender"
                        class="w-full border px-4 py-2 rounded @error('gender') border-red-500 @enderror">
                        <option value="">-- Sélectionner --</option>
                        <option value="male" @selected(old('gender') == 'male')>Mâle</option>
                        <option value="female" @selected(old('gender') == 'female')>Femelle</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="weight" class="block text-gray-700 font-medium mb-1">Poids (kg)</label>
                    <input type="number" step="0.1" min="0" name="weight" id="weight" value="{{ old('weight') }}"
                        class="w-full border px-4 py-2 rounded @error('weight') border-red-500 @enderror">
                    @error('weight') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="color" class="block text-gray-700 font-medium mb-1">Couleur</label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}"
                        class="w-full border px-4 py-2 rounded @error('color') border-red-500 @enderror">
                    @error('color') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="microchip_number" class="block text-gray-700 font-medium mb-1">Numéro de puce</label>
                    <input type="text" name="microchip_number" id="microchip_number" value="{{ old('microchip_number') }}"
                        class="w-full border px-4 py-2 rounded @error('microchip_number') border-red-500 @enderror">
                    @error('microchip_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="insurance_provider" class="block text-gray-700 font-medium mb-1">Assurance</label>
                    <input type="text" name="insurance_provider" id="insurance_provider"
                        value="{{ old('insurance_provider') }}"
                        class="w-full border px-4 py-2 rounded @error('insurance_provider') border-red-500 @enderror">
                    @error('insurance_provider') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>


                {{-- Scores des 6 piliers --}}
                <h2 class="text-lg font-bold text-gray-800 mt-6">📊 Scores (0 à 100)</h2>

                @foreach (['health', 'education', 'nutrition', 'activity', 'lifestyle', 'emotional'] as $pillar)
                    <div>
                        <label for="{{ $pillar }}_score" class="block text-gray-700">{{ ucfirst($pillar) }} Score</label>
                        <input type="number" name="{{ $pillar }}_score" id="{{ $pillar }}_score" min="0" max="100"
                            value="{{ old($pillar . '_score') }}" class="w-full border px-4 py-2 rounded">
                    </div>
                @endforeach

                {{-- Dossier santé --}}
                <h2 class="text-lg font-bold text-gray-800 mt-6">🏥 Dossier médical</h2>

                <div>
                    <label for="health_record[primary_vet_id]" class="block text-gray-700">Vétérinaire principal</label>
                    <select name="health_record[primary_vet_id]" id="health_record[primary_vet_id]"
                        class="w-full border px-4 py-2 rounded">
                        <option value="">-- Sélectionner --</option>
                        @foreach ($veterinarians as $vet)
                            <option value="{{ $vet->id }}" @selected(old('health_record.primary_vet_id') == $vet->id)>
                                {{ $vet->full_name }} — {{ $vet->clinic_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="health_record[blood_type]" class="block text-gray-700">Groupe sanguin</label>
                    <input type="text" name="health_record[blood_type]" id="health_record[blood_type]"
                        value="{{ old('health_record.blood_type') }}" class="w-full border px-4 py-2 rounded">
                </div>

                <div>
                    <label for="health_record[allergies]" class="block text-gray-700">Allergies</label>
                    <textarea name="health_record[allergies]" id="health_record[allergies]" rows="3"
                        class="w-full border px-4 py-2 rounded">{{ old('health_record.allergies') }}</textarea>
                </div>

                <div>
                    <label for="health_record[current_medications]" class="block text-gray-700">Médicaments en cours</label>
                    <textarea name="health_record[current_medications]" id="health_record[current_medications]" rows="3"
                        class="w-full border px-4 py-2 rounded">{{ old('health_record.current_medications') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('pets.index') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition">Annuler</a>
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Ajouter</button>
                </div>
        </form>
    </div>
@endsection