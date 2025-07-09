@extends('layouts.app')

@section('title', 'Ajouter un animal')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Ajouter un animal</h1>

        <form method="POST" action="{{ route('pets.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="species" class="block text-gray-700 font-medium mb-1">Espèce</label>
                <input type="text" name="species" id="species" value="{{ old('species') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="breed" class="block text-gray-700 font-medium mb-1">Race</label>
                <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="age" class="block text-gray-700 font-medium mb-1">Âge</label>
                <input type="number" name="age" id="age" value="{{ old('age') }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    ✅ Ajouter
                </button>
            </div>
        </form>
    </div>
@endsection