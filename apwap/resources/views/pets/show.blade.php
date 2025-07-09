@extends('layouts.app')

@section('title', 'Détails de l\'animal')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $pet->name }}</h2>

        <p class="mb-2"><strong class="text-gray-700">Espèce :</strong> <span
                class="text-gray-900">{{ $pet->species }}</span></p>
        <p class="mb-2"><strong class="text-gray-700">Race :</strong> <span class="text-gray-900">{{ $pet->breed }}</span>
        </p>
        <p class="mb-6"><strong class="text-gray-700">Âge :</strong> <span class="text-gray-900">{{ $pet->age }}</span></p>

        <div class="flex gap-4">
            <a href="{{ route('pets.edit', $pet) }}" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">
                ✏️ Modifier
            </a>

            <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                onsubmit="return confirm('Supprimer cet animal ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    🗑 Supprimer
                </button>
            </form>
        </div>

        <hr class="my-6 border-gray-300">
    </div>
@endsection