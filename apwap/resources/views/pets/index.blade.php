@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des animaux</h1>
        <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Ajouter un animal</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <ul class="list-group">
            @foreach($pets as $pet)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('pets.show', $pet) }}">{{ $pet->name }}</a>
                    <div>
                        <a href="{{ route('pets.edit', $pet) }}" class="btn btn-sm btn-secondary">Modifier</a>
                        <form action="{{ route('pets.destroy', $pet) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Supprimer cet animal ?')">Supprimer</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection