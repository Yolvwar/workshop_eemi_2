@extends('layouts.app')

@section('title', 'Liste des animaux')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🐾 Liste des animaux</h1>
            <a href="{{ route('pets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Ajouter un animal
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(count($pets))
            <ul class="space-y-3">
                @foreach($pets as $pet)
                    <li class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded hover:bg-gray-100">
                        <a href="{{ route('pets.show', $pet) }}" class="text-blue-600 font-medium hover:underline">
                            {{ $pet->name }}
                        </a>
                        <div class="flex gap-2">
                            <a href="{{ route('pets.edit', $pet) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                ✏️ Modifier
                            </a>
                            <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                                onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    🗑 Supprimer
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun animal enregistré pour le moment.</p>
        @endif
    </div>
@endsection