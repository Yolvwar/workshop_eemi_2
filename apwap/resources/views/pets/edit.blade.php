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
                <input type="text" id="species" name="species" value="{{ old('species', $pet->species) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('species') border-red-500 @enderror"
                    required>
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