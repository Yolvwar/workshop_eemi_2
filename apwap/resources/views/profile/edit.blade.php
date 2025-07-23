@extends('layouts.app')

@section('title', 'Mon Profil')
@section('page-title', 'Paramètres du Profil')

@section('content')
<div class="w-full">
    <!-- En-tête -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="p-8 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
            <div class="flex items-center space-x-6">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-3xl font-bold">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ auth()->user()->name ?? 'Utilisateur' }}</h1>
                    <p class="text-emerald-100">{{ auth()->user()->email }}</p>
                    <div class="flex items-center mt-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                        <span class="text-sm">Membre Premium</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Menu de navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                <nav class="space-y-2">
                    <a href="#profile-info" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-user class="w-5 h-5 mr-3" />
                        Informations personnelles
                    </a>
                    <a href="#security" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-shield-check class="w-5 h-5 mr-3" />
                        Sécurité
                    </a>
                    <a href="#notifications" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-bell class="w-5 h-5 mr-3" />
                        Notifications
                    </a>
                    <a href="#preferences" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-cog-6-tooth class="w-5 h-5 mr-3" />
                        Préférences
                    </a>
                    <a href="#billing" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-credit-card class="w-5 h-5 mr-3" />
                        Facturation
                    </a>
                    <a href="#privacy" 
                       class="profile-nav-link flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                        <x-heroicon-o-lock-closed class="w-5 h-5 mr-3" />
                        Confidentialité
                    </a>
                </nav>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Messages de succès/erreur -->
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="h-5 w-5 text-emerald-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-400" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Il y a eu {{ $errors->count() }} erreur(s) :
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations personnelles -->
            <section id="profile-info" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-user class="w-5 h-5 inline mr-2" />
                        Informations personnelles
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone ?? '') }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            </div>
                            
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                                <select id="location" 
                                        name="location" 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                    <option value="Dubai, UAE" {{ old('location', $user->location ?? '') == 'Dubai, UAE' ? 'selected' : '' }}>Dubai, UAE</option>
                                    <option value="Abu Dhabi, UAE" {{ old('location', $user->location ?? '') == 'Abu Dhabi, UAE' ? 'selected' : '' }}>Abu Dhabi, UAE</option>
                                    <option value="Sharjah, UAE" {{ old('location', $user->location ?? '') == 'Sharjah, UAE' ? 'selected' : '' }}>Sharjah, UAE</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea id="bio" 
                                      name="bio" 
                                      rows="3" 
                                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                      placeholder="Parlez-nous de vous et de vos animaux...">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-emerald-700 transition-colors">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Sécurité -->
            <section id="security" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-shield-check class="w-5 h-5 inline mr-2" />
                        Sécurité
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Changer mot de passe -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <h3 class="font-medium text-gray-900 mb-4">Changer le mot de passe</h3>
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('put')
                            
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                                Mettre à jour le mot de passe
                            </button>
                        </form>
                    </div>
                    
                    <!-- Authentification à deux facteurs -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">Authentification à deux facteurs</h3>
                                <p class="text-sm text-gray-600">Ajoutez une couche de sécurité supplémentaire</p>
                            </div>
                            <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                Configurer
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Notifications -->
            <section id="notifications" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-bell class="w-5 h-5 inline mr-2" />
                        Préférences de notification
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-medium text-gray-900">Rappels de rendez-vous</h3>
                                <p class="text-sm text-gray-600">Recevoir des rappels avant les consultations</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-medium text-gray-900">Alertes d'urgence</h3>
                                <p class="text-sm text-gray-600">Notifications pour les services d'urgence</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-medium text-gray-900">Promotions boutique</h3>
                                <p class="text-sm text-gray-600">Offres spéciales et nouveaux produits</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Préférences -->
            <section id="preferences" class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <x-heroicon-o-cog-6-tooth class="w-5 h-5 inline mr-2" />
                        Préférences du site
                    </h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
                            <select id="language" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="fr">Français</option>
                                <option value="en">English</option>
                                <option value="ar">العربية</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Fuseau horaire</label>
                            <select id="timezone" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                                <option value="Asia/Dubai">UAE (GMT+4)</option>
                                <option value="Europe/Paris">France (GMT+1)</option>
                                <option value="America/New_York">New York (GMT-5)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-medium text-gray-900">Mode sombre</h3>
                                <p class="text-sm text-gray-600">Interface avec thème sombre</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Zone de danger -->
            <section id="privacy" class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-red-500">
                <div class="p-6 border-b border-gray-200 bg-red-50">
                    <h2 class="text-xl font-semibold text-red-900">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5 inline mr-2" />
                        Zone de danger
                    </h2>
                </div>
                <div class="p-6">
                    <div class="border border-red-200 rounded-xl p-4 bg-red-50">
                        <h3 class="font-medium text-red-900 mb-2">Supprimer le compte</h3>
                        <p class="text-sm text-red-700 mb-4">
                            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.
                        </p>
                        <button type="button" 
                                onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors">
                            Supprimer le compte
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Supprimer le compte</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-4">
                            <label for="password_delete" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmez avec votre mot de passe
                            </label>
                            <input type="password" 
                                   id="password_delete" 
                                   name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="button" 
                                    onclick="document.getElementById('delete-modal').classList.add('hidden')"
                                    class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors">
                                Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.profile-nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
                
                document.querySelectorAll('.profile-nav-link').forEach(l => l.classList.remove('bg-emerald-50', 'text-emerald-700'));
                this.classList.add('bg-emerald-50', 'text-emerald-700');
            }
        });
    });
    
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log('Setting changed:', this.closest('.flex').querySelector('h3').textContent, this.checked);
        });
    });
});
</script>
@endsection
