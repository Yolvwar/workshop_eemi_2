<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Connexion</h2>
        <p class="text-gray-600">Accédez à votre espace APWAP</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Adresse email
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                   placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                Mot de passe
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember"
                       class="w-4 h-4 text-[#305F72] bg-white border-gray-300 rounded focus:ring-[#305F72] focus:ring-2">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                    Se souvenir de moi
                </label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-[#305F72] hover:text-[#D1A38E] transition-colors">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-[#305F72] text-white py-3 rounded-lg font-semibold hover:bg-[#1E3A44] transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
            Se connecter
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">Nouveau sur APWAP ?</span>
            </div>
        </div>
        
        <!-- Register Link -->
        <div class="text-center">
            <a href="{{ route('register') }}" 
               class="w-full inline-block py-3 px-6 border border-[#305F72] text-[#305F72] rounded-lg font-semibold hover:bg-[#305F72] hover:text-white transition-all duration-200">
                Créer un compte
            </a>
        </div>
    </form>
</x-guest-layout>
