@extends('layouts.app')

@section('title', 'Mes Animaux - APWAP')
@section('page-title', 'Mes Animaux')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-[#F9F5F0]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Premium -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Mes Compagnons
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Gérez la santé et le bien-être de vos animaux avec l'intelligence artificielle APWAP
            </p>
            <div class="mt-4 inline-flex items-center px-4 py-2 bg-[#305F72]/10 rounded-full">
                <div class="w-2 h-2 bg-[#305F72] rounded-full mr-2"></div>
                <span class="text-[#305F72] font-medium">{{ count($pets) }} compagnon{{ count($pets) > 1 ? 's' : '' }} enregistré{{ count($pets) > 1 ? 's' : '' }}</span>
            </div>
        </div>

        <!-- Actions rapides Premium -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('pets.create') }}" class="group relative bg-[#305F72]/5 hover:bg-[#305F72]/10 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-[#305F72] rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-plus class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Ajouter Animal</h3>
                    <p class="text-sm text-gray-600 mb-4">Enregistrez un nouveau compagnon</p>
                    <div class="flex items-center text-[#305F72] font-medium">
                        <span>Ajouter</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <a href="{{ route('consultations.create') }}" class="group relative bg-[#D1A38E]/10 hover:bg-[#D1A38E]/20 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-[#D1A38E] rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-calendar class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Consultation</h3>
                    <p class="text-sm text-gray-600 mb-4">Prendre rendez-vous vétérinaire</p>
                    <div class="flex items-center text-[#D1A38E] font-medium">
                        <span>Consulter</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <a href="{{ route('shop.index') }}" class="group relative bg-[#E7DCCB]/20 hover:bg-[#E7DCCB]/30 rounded-2xl p-6 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="w-12 h-12 bg-[#E7DCCB] rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-shopping-bag class="w-6 h-6 text-[#305F72]" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Boutique IA</h3>
                    <p class="text-sm text-gray-600 mb-4">Produits recommandés par l'IA</p>
                    <div class="flex items-center text-[#305F72] font-medium">
                        <span>Explorer</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                    </div>
                </a>

                <div class="group relative bg-gradient-to-r from-[#305F72]/5 to-[#D1A38E]/5 rounded-2xl p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#305F72] to-[#D1A38E] rounded-xl flex items-center justify-center mb-4">
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-white" />
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Score Moyen</h3>
                    <p class="text-sm text-gray-600 mb-2">Bien-être global de vos animaux</p>
                    <div class="text-2xl font-bold text-[#305F72]">{{ $pets->count() ? round($pets->avg('overall_score')) : 0 }}%</div>
                </div>
            </div>
        </div>
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