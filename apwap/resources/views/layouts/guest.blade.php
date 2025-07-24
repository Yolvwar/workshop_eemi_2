<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'APWAP') }} - Connexion</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
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
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Professional background -->
        <div class="min-h-screen relative">
            <!-- Subtle gradient background -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#F9F5F0] via-white to-[#E7DCCB]/30"></div>
            
            <!-- Professional accent line -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#305F72] to-[#D1A38E]"></div>
            
            <!-- Content -->
            <div class="relative z-10 min-h-screen flex">
                <!-- Left side - Branding -->
                <div class="hidden lg:flex lg:w-5/12 bg-[#305F72] flex-col justify-center px-12 relative overflow-hidden">
                    <!-- Subtle pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 70% 70%, rgba(209,163,142,0.1) 0%, transparent 50%);"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <img src="{{ asset('logo.png') }}" alt="APWAP" class="h-16 w-auto mb-8">
                        <h1 class="text-4xl font-bold text-white mb-6">
                            Soins Vétérinaires<br>
                            <span class="text-[#D1A38E]">Nouvelle Génération</span>
                        </h1>
                        <p class="text-[#E7DCCB] text-lg leading-relaxed mb-8">
                            Rejoignez la révolution de la gestion vétérinaire avec l'intelligence artificielle. 
                            Plus de 2000+ propriétaires d'animaux nous font confiance à Dubai.
                        </p>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#D1A38E]">95%</div>
                                <div class="text-[#E7DCCB] text-sm">Précision IA</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-[#D1A38E]">24/7</div>
                                <div class="text-[#E7DCCB] text-sm">Support</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - Form -->
                <div class="flex-1 flex flex-col justify-center px-8 sm:px-12 lg:px-16">
                    <!-- Mobile logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <a href="/" class="inline-flex items-center">
                            <img src="{{ asset('logo.png') }}" alt="APWAP" class="h-10 w-auto mr-3">
                            <span class="text-2xl font-bold text-[#305F72]">APWAP</span>
                        </a>
                    </div>

                    <!-- Auth Card -->
                    <div class="w-full max-w-lg mx-auto">
                        <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
                            {{ $slot }}
                        </div>
                    </div>
                    
                    <!-- Back to home link -->
                    <div class="mt-8 text-center">
                        <a href="/" class="text-[#305F72]/70 hover:text-[#305F72] transition-colors text-sm inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
