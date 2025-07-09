@extends('layouts.app')

@section('title', 'Ajouter un animal')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Ajouter un animal</h1>

        <form method="POST" action="{{ route('pets.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="species" class="block text-gray-700 font-medium mb-1">Espèce</label>
                <input type="text" name="species" id="species" value="{{ old('species') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('species') border-red-500 @enderror"
                    required>
                @error('species')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="breed" class="block text-gray-700 font-medium mb-1">Race</label>
                <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('breed') border-red-500 @enderror"
                    required>
                @error('breed')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="birth_date" class="block text-gray-700 font-medium mb-1">Date de naissance</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror">
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
                    Ajouter
                </button>
            </div>
        </form>
    </div>
@endsection