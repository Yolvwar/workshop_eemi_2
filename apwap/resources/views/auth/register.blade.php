<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Rejoindre APWAP</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Row 1: Name Fields -->
        <div class="grid grid-cols-2 gap-4">
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Prénom
                </label>
                <input id="first_name" 
                       type="text" 
                       name="first_name" 
                       value="{{ old('first_name') }}" 
                       required 
                       autofocus 
                       autocomplete="given-name"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="Prénom">
                <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-red-500 text-xs" />
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nom
                </label>
                <input id="last_name" 
                       type="text" 
                       name="last_name" 
                       value="{{ old('last_name') }}" 
                       required 
                       autocomplete="family-name"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="Nom">
                <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-red-500 text-xs" />
            </div>
        </div>

        <!-- Row 2: Email and Phone -->
        <div class="grid grid-cols-2 gap-4">
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
                       autocomplete="username"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="votre@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                    Téléphone
                </label>
                <input id="phone" 
                       type="tel" 
                       name="phone" 
                       value="{{ old('phone') }}" 
                       autocomplete="tel"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="+971 50 123 4567">
                <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-500 text-xs" />
            </div>
        </div>

        <!-- Row 3: Password Fields -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    Mot de passe
                </label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    Confirmer le mot de passe
                </label>
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                       placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs" />
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-[#305F72] text-white py-3 rounded-lg font-semibold hover:bg-[#1E3A44] transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
            Créer mon compte
        </button>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500">Déjà membre ?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <a href="{{ route('login') }}" 
               class="w-full inline-block py-3 px-6 border border-[#305F72] text-[#305F72] rounded-lg font-semibold hover:bg-[#305F72] hover:text-white transition-all duration-200">
                Se connecter
            </a>
        </div>
    </form>
</x-guest-layout>
