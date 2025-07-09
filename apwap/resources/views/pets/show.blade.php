@extends('layouts.app')

@section('title', 'Détails de l\'animal')

@section('content')
    <h2>{{ $pet->name }}</h2>
    <p><strong>Espèce:</strong> {{ $pet->species }}</p>
    <p><strong>Race:</strong> {{ $pet->breed }}</p>
    <p><strong>Âge:</strong> {{ $pet->age }}</p>

    <a href="{{ route('pets.edit', $pet) }}" class="btn btn-warning">Modifier</a>

    <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="d-inline"
        onsubmit="return confirm('Supprimer cet animal ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>

    <hr>

    <a href="{{ route('pets.consultations.index', $pet) }}" class="btn btn-outline-primary">Voir les consultations</a>
    <a href="{{ route('pets.photos.index', $pet) }}" class="btn btn-outline-secondary">Voir les photos</a>
    <a href="{{ route('pets.scores.show', $pet) }}" class="btn btn-outline-success">Voir le score</a>
@endsection