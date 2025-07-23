@extends('layouts.app')

@section('title', 'Liste des animaux')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Animaux</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Dubai, UAE • {{ count($pets) }} compagnon{{ count($pets) > 1 ? 's' : '' }}
                        • Score moyen: {{ round($pets->avg('overall_score')) ?? 0 }}%
                    </p>
                </div>
                <a href="{{ route('pets.create') }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                    <x-heroicon-o-plus-circle class="w-5 h-5" />
                    Ajouter Animal
                </a>
            </div>

            <!-- Pets Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($pets as $pet)
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6 space-y-4">
                            <!-- Pet Header -->
                            <div class="flex justify-between items-start">
                                <a href="{{ route('pets.show', $pet) }}" class="group">
                                    <h2
                                        class="text-xl font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">
                                        {{ $pet->name }} - {{ $pet->breed ?? 'Race inconnue' }}
                                        @if($pet->gender === 'male') ♂ @elseif($pet->gender === 'female') ♀ @endif
                                    </h2>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ \Carbon\Carbon::parse($pet->birth_date)->age }} ans
                                        ({{ round(\Carbon\Carbon::parse($pet->birth_date)->diffInMonths(now())) }} mois)
                                    </p>
                                </a>
                            </div>

                            <!-- Pet Stats -->
                            <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Score global</span>
                                    <span class="font-semibold text-emerald-600">{{ $pet->overall_score }}%</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span>🏥 Santé</span>
                                            <span class="font-medium">{{ $pet->health_score }}%</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span>🎓 Éducation</span>
                                            <span class="font-medium">{{ $pet->education_score }}%</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span>🍽️ Nutrition</span>
                                            <span class="font-medium">{{ $pet->nutrition_score }}%</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span>🏃 Activité</span>
                                            <span class="font-medium">{{ $pet->activity_score }}%</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span>🏡 Lifestyle</span>
                                            <span class="font-medium">{{ $pet->lifestyle_score }}%</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span>💙 Émotionnel</span>
                                            <span class="font-medium">{{ $pet->emotional_score }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 pt-2">
                                <a href="pets/{{ $pet->id }}/calendar"
                                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-medium text-sm transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-calendar class="w-5 h-5" />
                                    Planifier RDV
                                </a>
                                <a href="#"
                                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-medium text-sm transition-colors flex items-center justify-center gap-2">
                                    <x-heroicon-o-play class="w-5 h-5" />
                                    Activités
                                </a>
                            </div>

                            <div class="text-sm text-gray-500 pt-2">
                                Dernière visite: {{ optional($pet->updated_at)->format('d M') ?? 'Inconnue' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl shadow p-6 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-heroicon-o-face-frown class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-500">Aucun animal enregistré pour le moment.</p>
                        <a href="{{ route('pets.create') }}"
                            class="mt-4 inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
                            Ajouter mon premier animal
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection