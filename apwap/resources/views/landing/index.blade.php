<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APWAP - La Révolution de la Gestion Vétérinaire</title>
    <meta name="description" content="Gérez vos animaux avec l'IA. Consultations intelligentes, recommandations personnalisées, suivi premium. L'avenir des soins vétérinaires est là.">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .slide-in {
            animation: slideIn 0.8s ease-out forwards;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .scale-hover:hover {
            transform: scale(1.05);
        }
        .glow-effect {
            box-shadow: 0 0 20px rgba(209, 163, 142, 0.4);
        }
        .glow-effect:hover {
            box-shadow: 0 0 30px rgba(209, 163, 142, 0.6);
        }
        .gradient-text {
            background: linear-gradient(135deg, #305F72, #D1A38E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="APWAP" class="h-8 w-auto">
                    <span class="ml-2 text-xl font-bold text-[#305F72]">APWAP</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-[#305F72]/80 hover:text-[#305F72] transition-colors">Fonctionnalités</a>
                    <a href="#benefits" class="text-[#305F72]/80 hover:text-[#305F72] transition-colors">Avantages</a>
                    <a href="#demo" class="text-[#305F72]/80 hover:text-[#305F72] transition-colors">Démo</a>
                    <a href="#pricing" class="text-[#305F72]/80 hover:text-[#305F72] transition-colors">Tarifs</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-[#F9F5F0]/20 text-[#305F72] px-4 py-2 rounded-lg font-medium hover:bg-[#F9F5F0]/30 transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#305F72]/80 hover:text-[#305F72] transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#305F72] to-[#D1A38E] text-white px-6 py-2 rounded-lg font-medium hover:shadow-lg transform hover:scale-105 transition-all">
                            Essayer Gratuitement
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Dark gradient background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#305F72] via-[#305F72]/95 to-[#305F72]/90"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#305F72]/95 to-[#305F72]/70"></div>
        
        <!-- Subtle mesh pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>
        </div>
        
        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="slide-in">
                <h1 class="text-6xl lg:text-8xl font-bold text-white mb-6 leading-tight">
                    L'IA au Service<br>
                    de <span class="bg-gradient-to-r from-[#D1A38E] to-[#F9F5F0] bg-clip-text text-transparent">Vos Animaux</span>
                </h1>
                <p class="text-xl lg:text-2xl text-gray-300 mb-8 max-w-4xl mx-auto leading-relaxed">
                    APWAP révolutionne la gestion vétérinaire avec l'intelligence artificielle. 
                    Recommandations personnalisées, consultations intelligentes, suivi premium automatisé.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-[#305F72] to-[#D1A38E] text-white px-10 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                            Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#305F72] to-[#D1A38E] text-white px-10 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                            Commencer Gratuitement
                        </a>
                    @endauth
                    <a href="#demo" class="glass-effect text-white px-10 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all">
                        Voir la Démo
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
                    <div class="glass-effect rounded-2xl p-6 hover:bg-white/10 transition-all">
                        <div class="text-3xl font-bold text-[#F9F5F0] mb-2">{{ $stats['total_pets'] }}+</div>
                        <div class="text-[#E7DCCB]">Animaux Suivis</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover:bg-white/10 transition-all">
                        <div class="text-3xl font-bold text-[#F9F5F0] mb-2">95%</div>
                        <div class="text-[#E7DCCB]">Précision IA</div>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 hover:bg-white/10 transition-all">
                        <div class="text-3xl font-bold text-[#F9F5F0] mb-2">24/7</div>
                        <div class="text-[#E7DCCB]">Disponibilité</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Elegant scroll indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white/30 rounded-full mt-2"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gradient-to-br from-[#F9F5F0] to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold text-[#305F72] mb-6">
                    Une Plateforme <span class="gradient-text">Révolutionnaire</span>
                </h2>
                <p class="text-xl text-[#305F72]/70 max-w-3xl mx-auto">
                    Découvrez comment APWAP transforme la gestion de vos animaux avec des technologies de pointe
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Feature 1: IA Dashboard -->
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all scale-hover">
                    <div class="w-16 h-16 bg-[#305F72] rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#305F72] mb-4">Dashboard IA Intelligent</h3>
                    <p class="text-[#305F72]/70 mb-6">
                        Tableau de bord alimenté par l'IA qui analyse les données de vos animaux et fournit des insights personnalisés en temps réel.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#305F72] rounded-full mr-3"></div>
                            Recommandations automatiques
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#305F72] rounded-full mr-3"></div>
                            Alertes prédictives
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Analytics avancés
                        </li>
                    </ul>
                </div>
                
                <!-- Feature 2: Smart Consultations -->
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all scale-hover">
                    <div class="w-16 h-16 bg-[#D1A38E] rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#305F72] mb-4">Consultations Intelligentes</h3>
                    <p class="text-[#305F72]/70 mb-6">
                        Système de consultation alimenté par l'IA qui optimise automatiquement les rendez-vous et les recommandations de soins.
                    </p>
                    <ul class="space-y-2 text-[#305F72]/70">
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Diagnostic assisté par IA
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Planification optimisée
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Suivi automatique
                        </li>
                    </ul>
                </div>
                
                <!-- Feature 3: Premium Care -->
                <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all scale-hover">
                    <div class="w-16 h-16 bg-[#E7DCCB] rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[#305F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#305F72] mb-4">Gestion Premium</h3>
                    <p class="text-[#305F72]/70 mb-6">
                        Gestion complète de vos animaux avec des fonctionnalités premium et un suivi personnalisé de bout en bout.
                    </p>
                    <ul class="space-y-2 text-[#305F72]/70">
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Profils détaillés
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Historique complet
                        </li>
                        <li class="flex items-center">
                            <div class="w-2 h-2 bg-[#D1A38E] rounded-full mr-3"></div>
                            Rappels automatiques
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-24 bg-[#305F72] text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#305F72]/90 to-[#D1A38E]/20"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold mb-6">
                    Pourquoi Choisir <span class="gradient-text">APWAP</span> ?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    L'innovation rencontre l'expertise vétérinaire pour offrir une expérience sans précédent
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#1E3A44] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Recommandations IA Instantanées</h3>
                            <p class="text-gray-300">
                                Notre IA analyse en temps réel les données de vos animaux pour fournir des recommandations personnalisées et prédictives.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#D1A38E] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Dashboard Intelligent</h3>
                            <p class="text-gray-300">
                                Interface intuitive qui centralise toutes les informations de vos animaux avec des insights avancés et des alertes proactives.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#E7DCCB] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[#305F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Gestion Automatisée</h3>
                            <p class="text-gray-300">
                                Rappels automatiques, planification intelligente et suivi continu pour ne jamais manquer un moment important.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="glass-effect rounded-3xl p-8">
                        <div class="text-center mb-6">
                            <div class="text-6xl mb-4">🤖</div>
                            <h3 class="text-2xl font-bold text-white mb-2">Powered by AI</h3>
                            <p class="text-gray-300">Intelligence artificielle au service du bien-être animal</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-white/10 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-medium">Précision diagnostique</span>
                                    <span class="text-[#D1A38E] font-bold">95%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-[#305F72] h-2 rounded-full" style="width: 95%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-white/10 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-medium">Satisfaction clients</span>
                                    <span class="text-[#E7DCCB] font-bold">98%</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-[#D1A38E] h-2 rounded-full" style="width: 98%"></div>
                                </div>
                            </div>
                            
                            <div class="bg-white/10 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-medium">Temps de réponse</span>
                                    <span class="text-[#F9F5F0] font-bold">< 2min</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-[#E7DCCB] h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-24 bg-gradient-to-br from-[#F9F5F0] to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold text-[#305F72] mb-6">
                    Voyez APWAP en Action
                </h2>
                <p class="text-xl text-[#305F72]/70 max-w-3xl mx-auto">
                    Découvrez comment notre plateforme révolutionne la gestion vétérinaire avec des démonstrations interactives
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="bg-gradient-to-r from-[#E7DCCB]/30 to-[#F9F5F0] rounded-3xl p-8 shadow-xl">
                        <div class="bg-white rounded-2xl p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-[#305F72]">Dashboard APWAP</h3>
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-[#D1A38E] rounded-full"></div>
                                    <div class="w-3 h-3 bg-[#E7DCCB] rounded-full"></div>
                                    <div class="w-3 h-3 bg-[#305F72] rounded-full"></div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-gradient-to-r from-[#305F72]/10 to-[#D1A38E]/10 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-[#305F72] rounded-full flex items-center justify-center">
                                            🐕
                                        </div>
                                        <div>
                                            <div class="font-semibold text-[#305F72]">Max</div>
                                            <div class="text-sm text-[#305F72]/60">Prochain rappel: Vaccination dans 3 jours</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-[#D1A38E]/10 to-[#E7DCCB]/10 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-[#D1A38E] rounded-full flex items-center justify-center">
                                            🐱
                                        </div>
                                        <div>
                                            <div class="font-semibold text-[#305F72]">Luna</div>
                                            <div class="text-sm text-[#305F72]/60">IA recommande: Contrôle dentaire</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-[#E7DCCB]/20 to-[#D1A38E]/20 rounded-lg p-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-[#305F72]">3 alertes IA</div>
                                        <div class="text-sm text-[#305F72]/60">Recommandations personnalisées disponibles</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-sm text-[#305F72]/50 mb-2">Aperçu du Dashboard IA</div>
                            <div class="flex justify-center space-x-1">
                                <div class="w-2 h-2 bg-[#305F72] rounded-full animate-pulse"></div>
                                <div class="w-2 h-2 bg-[#D1A38E] rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="w-2 h-2 bg-[#E7DCCB] rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <h3 class="text-3xl font-bold text-[#305F72] mb-4">L'IA qui Comprend Vos Animaux</h3>
                        <p class="text-[#305F72]/70 mb-6">
                            Notre système d'intelligence artificielle analyse les habitudes, la santé et les besoins de vos animaux 
                            pour fournir des recommandations ultra-personnalisées.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-[#D1A38E] rounded-full flex items-center justify-center">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-[#305F72]/80">Analyse prédictive des besoins de santé</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-[#305F72] rounded-full flex items-center justify-center">
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                </div>
                                <span class="text-[#305F72]/80">Recommandations basées sur l'âge et la race</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-[#E7DCCB] rounded-full flex items-center justify-center">
                                    <div class="w-3 h-3 bg-[#305F72] rounded-full"></div>
                                </div>
                                <span class="text-[#305F72]/80">Alertes préventives automatiques</span>
                            </div>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-gradient-to-r from-[#305F72] to-[#D1A38E] text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                            Découvrir Mon Dashboard
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center bg-gradient-to-r from-[#305F72] to-[#D1A38E] text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                            Essayer Gratuitement
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">
                    Des Tarifs <span class="gradient-text">Transparents</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choisissez le plan qui correspond à vos besoins. Toujours avec la même qualité de service premium.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Plan Starter -->
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                        <p class="text-gray-600 mb-4">Parfait pour débuter</p>
                        <div class="text-4xl font-bold text-gray-900">Gratuit</div>
                        <div class="text-gray-500">Pour 1 animal</div>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Profil animal complet</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Rappels basiques</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Consultations standards</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('register') }}" class="w-full bg-gray-900 text-white py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors text-center block">
                        Commencer Gratuitement
                    </a>
                </div>
                
                <!-- Plan Premium -->
                <div class="bg-gradient-to-br from-[#305F72] to-[#D1A38E] rounded-3xl shadow-xl p-8 text-white relative transform scale-105">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="bg-[#F9F5F0] text-[#305F72] px-4 py-1 rounded-full text-sm font-bold">
                            Le Plus Populaire
                        </div>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2">Premium IA</h3>
                        <p class="text-[#F9F5F0]/90 mb-4">Intelligence artificielle complète</p>
                        <div class="text-4xl font-bold">199 AED</div>
                        <div class="text-[#F9F5F0]/80">/ mois</div>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Animaux illimités</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Recommandations IA avancées</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Dashboard analytics complet</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Téléconsultations prioritaires</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Support prioritaire 24/7</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('register') }}" class="w-full bg-white text-[#305F72] py-3 rounded-xl font-medium hover:bg-[#F9F5F0] transition-colors text-center block">
                        Choisir Premium
                    </a>
                </div>
                
                <!-- Plan Enterprise -->
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                        <p class="text-gray-600 mb-4">Pour les professionnels</p>
                        <div class="text-4xl font-bold text-gray-900">Sur Mesure</div>
                        <div class="text-gray-500">Contactez-nous</div>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">API complète</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Intégrations personnalisées</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Support dédié</span>
                        </li>
                    </ul>
                    
                    <a href="#contact" class="w-full bg-gray-900 text-white py-3 rounded-xl font-medium hover:bg-gray-800 transition-colors text-center block">
                        Nous Contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-24 bg-gradient-to-r from-[#305F72] via-[#305F72]/90 to-[#D1A38E] text-white relative overflow-hidden">
        <div class="absolute inset-0 mesh-bg opacity-30"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl lg:text-6xl font-bold mb-6">
                Rejoignez la Révolution
            </h2>
            <p class="text-xl text-[#F9F5F0]/90 mb-12 max-w-2xl mx-auto">
                Plus de {{ $stats['total_pets'] }} propriétaires d'animaux font déjà confiance à APWAP. 
                Découvrez pourquoi notre plateforme change la donne dans les soins vétérinaires.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center mb-12">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-[#D1A38E] to-[#F9F5F0] text-[#305F72] px-12 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                        Accéder à Mon Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#D1A38E] to-[#F9F5F0] text-[#305F72] px-12 py-4 rounded-xl font-semibold text-lg hover:shadow-2xl transform hover:scale-105 transition-all glow-effect">
                        Essayer Gratuitement
                    </a>
                @endauth
                <a href="#features" class="glass-effect text-white px-12 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-all">
                    En Savoir Plus
                </a>
            </div>
            
            <!-- Trust badges -->
            <div class="flex justify-center items-center space-x-8 opacity-60">
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $stats['satisfaction_rate'] }}%</div>
                    <div class="text-sm">Satisfaction</div>
                </div>
                <div class="w-px h-12 bg-white/30"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold">95%</div>
                    <div class="text-sm">Précision IA</div>
                </div>
                <div class="w-px h-12 bg-white/30"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold">24/7</div>
                    <div class="text-sm">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('logo.png') }}" alt="APWAP" class="h-8 w-auto mr-2">
                        <span class="text-xl font-bold">APWAP</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        La plateforme de gestion vétérinaire alimentée par l'IA qui révolutionne les soins pour vos animaux.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.754-1.378l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.986C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Plateforme</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#demo" class="hover:text-white transition-colors">Démo</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Inscription</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>+971 4 XXX XXXX</li>
                        <li>hello@apwap.ae</li>
                        <li>APWAP Innovation Hub<br>Dubai, UAE</li>
                        <li class="pt-2">
                            <span class="text-[#D1A38E] font-semibold">Support IA 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 APWAP. Tous droits réservés. | Powered by Artificial Intelligence</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('slide-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.scale-hover, .feature-card').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
</html>
