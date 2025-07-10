@extends('layouts.app')

@section('title', 'Liste des animaux')

@section('content')
    <div class="max-w-7xl mx-auto my-8 bg-white p-6 rounded-lg shadow space-y-6">

        <div class="mx-8 bg-white p-6 rounded-lg space-y-6">
            <div class="flex items-center justify-between border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">🐾 Mes Animaux</h1>
                <a href="{{ route('pets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Ajouter Animal
                </a>
            </div>

            <p class="text-sm text-gray-600">Dubai, UAE • {{ count($pets) }} compagnon{{ count($pets) > 1 ? 's' : '' }}
                • Score moyen: {{ round($pets->avg('overall_score')) ?? 0 }}%</p>

            @forelse($pets as $pet)
                <div class="border-t pt-6 space-y-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('pets.show', $pet) }}">
                                <h2 class="text-lg font-semibold text-gray-800 hover:underline">
                                    🐾 {{ $pet->name }} - {{ $pet->breed ?? 'Race inconnue' }}
                                    @if($pet->gender === 'male') ♂ @elseif($pet->gender === 'female') ♀ @endif •
                                    {{ \Carbon\Carbon::parse($pet->birth_date)->age }} ans
                                    ({{ round(\Carbon\Carbon::parse($pet->birth_date)->diffInMonths(now())) }} mois)
                                </h2>
                            </a>
                            <p class="text-sm text-gray-600 mt-1">
                                📊 Score global: {{ $pet->overall_score }}% &nbsp;&nbsp;
                                📅 Dernière visite: {{ optional($pet->updated_at)->format('d M') ?? 'Inconnue' }}
                            </p>
                            <p class="text-sm italic text-gray-500 mt-1">
                                🎯 Focus: {{ $pet->markings ?? 'À définir' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4 text-sm text-gray-700 space-y-1">
                        <div class="flex flex-wrap justify-between">
                            <span>🏥 Santé: {{ $pet->health_score }}%</span>
                            <span>🎓 Éducation: {{ $pet->education_score }}%</span>
                            <span>🍽️ Nutrition: {{ $pet->nutrition_score }}%</span>
                        </div>
                        <div class="flex flex-wrap justify-between">
                            <span>🏃 Activité: {{ $pet->activity_score }}%</span>
                            <span>🏡 Lifestyle: {{ $pet->lifestyle_score }}%</span>
                            <span>💙 Émotionnel: {{ $pet->emotional_score }}%</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 pt-2">
                        <a href="#" class="text-purple-600 hover:underline">📅 Planifier RDV</a>
                        <a href="#" class="text-green-600 hover:underline">🏃 Activités</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Aucun animal enregistré pour le moment.</p>
            @endforelse
        </div>
    </div>
@endsection