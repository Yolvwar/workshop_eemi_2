@extends('layouts.app')

@section('title', $pet->name . ' - Profil')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg px-8 py-6">
            <!-- En-tête avec titre et actions -->
            <div class="flex justify-between items-start flex-wrap gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        @if ($pet->species === 'chat')
                            <x-heroicon-o-sparkles class="w-8 h-8 text-purple-500" />
                        @elseif ($pet->species === 'chien')
                            <x-heroicon-o-heart class="w-8 h-8 text-emerald-500" />
                        @else
                            <x-heroicon-o-star class="w-8 h-8 text-blue-500" />
                        @endif
                        {{ $pet->name }}
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $pet->breed ?? 'Race inconnue' }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('pets.edit', $pet) }}"
                        class="inline-flex items-center bg-emerald-600 text-white px-4 py-2 rounded-xl hover:bg-emerald-700 transition-colors duration-200 gap-2 shadow-sm">
                        <x-heroicon-o-pencil class="w-5 h-5" />
                        Modifier
                    </a>
                    <a href="#"
                        class="inline-flex items-center bg-purple-600 text-white px-4 py-2 rounded-xl hover:bg-purple-700 transition-colors duration-200 gap-2 shadow-sm">
                        <x-heroicon-o-camera class="w-5 h-5" />
                        Galerie ({{ $pet->photos->count() ?? 0 }})
                    </a>
                </div>
            </div>

            <!-- Score et dernière visite -->
            <div class="bg-gray-50 rounded-xl p-4 flex justify-between items-center mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-emerald-600" />
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Score global</div>
                        <div class="font-semibold text-emerald-600">{{ $pet->overall_score }}%</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <x-heroicon-o-calendar class="w-6 h-6 text-blue-600" />
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Dernière visite</div>
                        <div class="font-medium">{{ optional($pet->updated_at)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Informations en grille -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Informations générales -->
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <x-heroicon-o-identification class="w-5 h-5 text-emerald-600" />
                        Informations générales
                    </h2>
                    <ul class="space-y-3">
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Nom</span>
                            <span class="font-medium text-gray-900">{{ $pet->name }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Race</span>
                            <span class="font-medium text-gray-900">{{ $pet->breed ?? '—' }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Âge</span>
                            <span class="font-medium text-gray-900">
                                @if($pet->birth_date)
                                    {{ \Carbon\Carbon::parse($pet->birth_date)->age }} ans
                                @else
                                    Inconnu
                                @endif
                            </span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Sexe</span>
                            <span class="font-medium text-gray-900">
                                {{ ucfirst($pet->gender) }}
                                @if($pet->is_neutered)
                                    <span class="text-emerald-600">(castré)</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Santé & Médical -->
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <x-heroicon-o-heart class="w-5 h-5 text-red-600" />
                        Santé & Médical
                    </h2>
                    <ul class="space-y-3">
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Vétérinaire</span>
                            <span class="font-medium text-gray-900">{{ $pet->healthRecord->primary_vet_name ?? '—' }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Groupe sanguin</span>
                            <span class="font-medium text-gray-900">{{ $pet->healthRecord->blood_type ?? '—' }}</span>
                        </li>
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-600">Allergies</span>
                            <span class="font-medium text-gray-900">{{ $pet->healthRecord->allergies ?? '—' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Caractère -->
                <div class="bg-white rounded-xl border border-gray-100 p-6 md:col-span-2">
                    <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <x-heroicon-o-sparkles class="w-5 h-5 text-purple-600" />
                        Caractère & Comportement
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <ul class="space-y-3">
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Niveau d'énergie</span>
                                <span class="font-medium text-gray-900">{{ $pet->energy_level }}/10</span>
                            </li>
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Sociabilité</span>
                                <span class="font-medium text-gray-900">{{ $pet->sociability }}</span>
                            </li>
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Obéissance</span>
                                <span class="font-medium text-gray-900">{{ $pet->obedience_level }}/10</span>
                            </li>
                        </ul>
                        <ul class="space-y-3">
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Peurs</span>
                                <span class="font-medium text-gray-900">{{ $pet->fears_phobias ?? '—' }}</span>
                            </li>
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-600">Jouets préférés</span>
                                <span class="font-medium text-gray-900">{{ $pet->favorite_toys ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                <div class="flex gap-3">
                    <a href="{{ route('pets.calendar.index', $pet) }}"
                        class="inline-flex items-center bg-purple-600 text-white px-4 py-2 rounded-xl hover:bg-purple-700 transition-colors duration-200 gap-2 shadow-sm">
                        <x-heroicon-o-calendar class="w-5 h-5" />
                        Calendrier
                    </a>
                </div>

                <form action="{{ route('pets.destroy', $pet) }}" method="POST"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition-colors duration-200 gap-2 shadow-sm">
                        <x-heroicon-o-trash class="w-5 h-5" />
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection