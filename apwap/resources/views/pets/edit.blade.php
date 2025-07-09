@extends('layouts.app')

@section('title', 'Modifier l\'animal')

@section('content')
    <form method="POST" action="{{ route('pets.update', $pet) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pet->name) }}">
        </div>

        <div class="mb-3">
            <label for="species" class="form-label">Espèce</label>
            <input type="text" name="species" class="form-control" value="{{ old('species', $pet->species) }}">
        </div>

        <div class="mb-3">
            <label for="breed" class="form-label">Race</label>
            <input type="text" name="breed" class="form-control" value="{{ old('breed', $pet->breed) }}">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Âge</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $pet->age) }}">
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
@endsection