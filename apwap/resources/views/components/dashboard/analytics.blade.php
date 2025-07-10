<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics des 6 Piliers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
        
        .progress-bar {
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }
        
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-8xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Analytics des 6 Piliers</h2>
                            <p class="text-sm text-gray-500">Suivi du bien-être de vos compagnons</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export
                        </button>
                        <button class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                            </svg>
                            Historique
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">🐕</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-yellow-500 border-2 border-white rounded-full pulse-dot"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">Buddy</h3>
                        <p class="text-sm text-gray-600">Labrador • Mâle • 8 ans</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded-full">32kg</span>
                            <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full">Stérilisé</span>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-sm font-medium text-red-900">Conditions médicales</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded">Arthrite</span>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded">Surpoids</span>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-purple-900">Personnalité</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded">Calme</span>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded">Affectueux</span>
                        <span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded">Gourmand</span>
                    </div>
                </div>

                <div class="bg-green-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a2.5 2.5 0 012.5 2.5v0a2.5 2.5 0 01-2.5 2.5H9m-1.5 0H7a2 2 0 01-2-2v-4a2 2 0 012-2h1.5M9 10v10m0 0h1.5a2.5 2.5 0 002.5-2.5v0a2.5 2.5 0 00-2.5-2.5H9v5z"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-900">Activités favorites</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Siestes</span>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Jeux doux</span>
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Caresses</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">Bien-être général</span>
                        <span class="text-xs font-medium text-gray-700">68%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-1.5 rounded-full" style="width: 68%"></div>
                    </div>
                    <div class="grid grid-cols-6 gap-1 mt-3">
                        <div class="text-center">
                            <div class="w-2 h-2 bg-red-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏥</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🍽️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏃</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🧠</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🌡️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-indigo-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">👥</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <button class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Voir détails</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Modifier</span>
                    </button>
                </div>
            </div>

            <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">🐱</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">Max</h3>
                        <p class="text-sm text-gray-600">Maine Coon • Mâle • 3 ans</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded-full">6.2kg</span>
                            <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full">Stérilisé</span>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-900">Excellent état</span>
                    </div>
                    <p class="text-xs text-green-700">Aucun problème de santé détecté</p>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-blue-900">Personnalité</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Joueur</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Curieux</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Énergique</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">Bien-être général</span>
                        <span class="text-xs font-medium text-gray-700">92%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-1.5 rounded-full" style="width: 92%"></div>
                    </div>
                    <div class="grid grid-cols-6 gap-1 mt-3">
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏥</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🍽️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏃</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🧠</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🌡️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">👥</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <button class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Voir détails</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm text-blue-600 hover:text-blue-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Modifier</span>
                    </button>
                </div>
            </div>

            <div class="card-hover bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">🐰</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">Luna</h3>
                        <p class="text-sm text-gray-600">Lapin Nain • Femelle • 2 ans</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="text-xs px-2 py-1 bg-pink-50 text-pink-700 rounded-full">1.2kg</span>
                            <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full">Stérilisée</span>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-900">Excellente santé</span>
                    </div>
                    <p class="text-xs text-green-700">Vaccination à jour, excellent appétit</p>
                </div>

                <div class="bg-pink-50 rounded-xl p-4 mb-4">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-pink-900">Personnalité</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        <span class="text-xs px-2 py-1 bg-pink-100 text-pink-800 rounded">Timide</span>
                        <span class="text-xs px-2 py-1 bg-pink-100 text-pink-800 rounded">Douce</span>
                        <span class="text-xs px-2 py-1 bg-pink-100 text-pink-800 rounded">Observatrice</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-500">Bien-être général</span>
                        <span class="text-xs font-medium text-gray-700">88%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-1.5 rounded-full" style="width: 88%"></div>
                    </div>
                    <div class="grid grid-cols-6 gap-1 mt-3">
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏥</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🍽️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🏃</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🧠</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">🌡️</span>
                        </div>
                        <div class="text-center">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mx-auto mb-1"></div>
                            <span class="text-xs text-gray-400">👥</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <button class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Voir détails</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm text-pink-600 hover:text-pink-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Modifier</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">📊 Résumé Global</h3>
                <p class="text-sm text-gray-500 mt-1">Vue d'ensemble des 6 piliers de bien-être</p>
            </div>
            
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-medium text-gray-900">Moyennes par pilier</h4>
                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span>Excellent (90+)</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                <span>Bon (70-89)</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span>À surveiller (&lt;70)</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-red-500 to-red-400 rounded-t w-6 transition-all duration-1000" style="height: 65%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-red-600 mb-1">67%</div>
                                <div class="text-gray-600">🏥 Santé</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-green-500 to-green-400 rounded-t w-6 transition-all duration-1000" style="height: 92%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-green-600 mb-1">92%</div>
                                <div class="text-gray-600">🍽️ Nutrition</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-yellow-500 to-yellow-400 rounded-t w-6 transition-all duration-1000" style="height: 78%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-yellow-600 mb-1">78%</div>
                                <div class="text-gray-600">🏃 Activité</div>
                            </div>
                        </div>
                        

                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-blue-500 to-blue-400 rounded-t w-6 transition-all duration-1000" style="height: 85%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-blue-600 mb-1">85%</div>
                                <div class="text-gray-600">🧠 Mental</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-purple-500 to-purple-400 rounded-t w-6 transition-all duration-1000" style="height: 82%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-purple-600 mb-1">82%</div>
                                <div class="text-gray-600">🌡️ Environnement</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-gray-100 rounded-xl h-24 flex items-end justify-center p-2 mb-2">
                                <div class="bg-gradient-to-t from-indigo-500 to-indigo-400 rounded-t w-6 transition-all duration-1000" style="height: 88%"></div>
                            </div>
                            <div class="text-xs">
                                <div class="font-semibold text-indigo-600 mb-1">88%</div>
                                <div class="text-gray-600">👥 Social</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-red-900">Attention requise</h4>
                                <p class="text-xs text-red-700">Santé de Buddy à surveiller</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-green-900">Excellent résultat</h4>
                                <p class="text-xs text-green-700">Nutrition parfaitement maîtrisée</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-900">Progression</h4>
                                <p class="text-xs text-blue-700">+5% d'amélioration ce mois</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Mise à jour: {{ date('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full pulse-dot"></div>
                            <span>Données synchronisées</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Exporter rapport
                        </button>
                        <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Configurer alertes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animation d'entrée des cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Animation des barres de progression
            setTimeout(() => {
                const progressBars = document.querySelectorAll('[style*="height:"]');
                progressBars.forEach(bar => {
                    const height = bar.style.height;
                    bar.style.height = '0%';
                    setTimeout(() => {
                        bar.style.height = height;
                    }, 500);
                });
            }, 1000);
        });
    </script>
</body>
</html>