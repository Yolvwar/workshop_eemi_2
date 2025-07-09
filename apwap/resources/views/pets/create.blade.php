@extends('layouts.app')

@section('title', 'Ajouter un animal')

@section('content')
    <form method="POST" action="{{ route('pets.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="species" class="form-label">Espèce</label>
            <input type="text" name="species" class="form-control" value="{{ old('species') }}">
        </div>

        <div class="mb-3">
            <label for="breed" class="form-label">Race</label>
            <input type="text" name="breed" class="form-control" value="{{ old('breed') }}">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Âge</label>
            <input type="number" name="age" class="form-control" value="{{ old('age') }}">
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
@endsection