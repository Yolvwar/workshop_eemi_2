@extends('layouts.app')

@section('title', $pet->name . ' - Profil')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow mt-8 space-y-6">
        <!-- En-tête avec titre, boutons modifier et galerie -->
        <div class="flex justify-between items-start flex-wrap gap-4">
            <h1 class="text-3xl font-bold text-gray-800">
                🐕 {{ $pet->name }} - {{ $pet->breed ?? 'Race inconnue' }}
            </h1>
            <div class="flex gap-2">
                <a href="{{ route('pets.edit', $pet) }}"
                    class="inline-flex items-center bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">
                    ✏️ Modifier
                </a>
                <a href="#" class="inline-flex items-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    📸 Galerie ({{ $pet->photos->count() ?? 0 }})
                </a>
            </div>
        </div>

        <!-- Score + dernière visite alignée à droite -->
        <div class="flex justify-between items-center text-sm text-gray-600">
            <span>⭐ Score global : {{ $pet->overall_score }}%</span>
            <span class="text-right">📅 Dernière visite : {{ optional($pet->updated_at)->format('d M Y') }}</span>
        </div>

        <!-- Informations générales -->
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-800 mb-2">📋 Informations générales</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>• Nom complet : {{ $pet->name }}</li>
                <li>• Race : {{ $pet->breed ?? '—' }}</li>
                <li>• Âge :
                    @if($pet->birth_date)
                        {{ \Carbon\Carbon::parse($pet->birth_date)->age }} ans (né le
                        {{ \Carbon\Carbon::parse($pet->birth_date)->format('d m Y') }})
                    @else
                        Inconnu
                    @endif
                </li>
                <li>• Sexe : {{ ucfirst($pet->gender) }} @if($pet->is_neutered) (castré) @endif</li>
                <li>• Poids : {{ $pet->weight ? $pet->weight . ' kg' : '—' }}</li>
                <li>• Couleur : {{ $pet->color ?? '—' }}</li>
                <li>• Puce : {{ $pet->microchip_number ?? '—' }}</li>
                <li>• Assurance : {{ $pet->insurance_provider ?? '—' }}</li>
            </ul>
        </div>

        <!-- Santé & Médical -->
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-800 mb-2">🏥 Santé & Médical</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>• Vétérinaire : {{ $pet->health_record->primary_vet_name ?? '—' }}</li>
                <li>• Groupe sanguin : {{ $pet->health_record->blood_type ?? '—' }}</li>
                <li>• Vaccinations :
                    {{ $pet->vaccinations->count() ? '✅ À jour (prochaines : ' . $pet->vaccinations->pluck('next_due_date')->max()->format('M Y') . ')' : '—' }}
                </li>
                <li>• Allergies : {{ $pet->health_record->allergies ?? '—' }}</li>
                <li>• Médicaments : {{ $pet->health_record->current_medications ?? '—' }}</li>
                <li>• Chirurgies :
                </li>
                <li>• Prochains soins : Bilan annuel recommandé</li>
            </ul>
        </div>

        <!-- Caractère & Comportement -->
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-800 mb-2">🎯 Caractère & Comportement</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>• Niveau d'énergie : {{ $pet->energy_level }}/10</li>
                <li>• Sociabilité : {{ $pet->sociability }}</li>
                <li>• Obéissance : {{ $pet->obedience_level }}/10</li>
                <li>• Peurs : {{ $pet->fears_phobias ?? '—' }}</li>
                <li>• Jouets préférés : {{ $pet->favorite_toys ?? '—' }}</li>
                <li>• Habitudes : {{ $pet->exercise_routine ?? '—' }}</li>
            </ul>
        </div>

        <!-- Alimentation -->
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-800 mb-2">🍽️ Alimentation</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>• Régime : {{ $pet->feeding_schedule ?? '—' }}</li>
                <li>• Quantité & horaires : à définir</li>
                <li>• Friandises & compléments : à compléter</li>
                <li>• Intolérances : à préciser</li>
            </ul>
        </div>

        <!-- Activité Physique -->
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-800 mb-2">🏃 Activité Physique</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>• Promenades : à compléter</li>
                <li>• Jeux & activité : à définir</li>
                <li>• Dressage & activités : à planifier</li>
            </ul>
        </div>

        <!-- Supprimer bouton en bas -->
        <div class="pt-4 flex justify-end">
            <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                onsubmit="return confirm('Supprimer cet animal ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    🗑 Supprimer
                </button>
            </form>
        </div>

    </div>
@endsection