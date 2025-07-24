<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-[#305F72] mb-2">Mot de passe oublié</h2>
        <p class="text-[#305F72]/70 text-sm leading-relaxed">
            Aucun problème ! Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-[#305F72] mb-2">
                Email
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus
                   class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#305F72] focus:border-transparent transition-all"
                   placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-[#305F72] text-white py-3 rounded-lg font-semibold hover:bg-[#1E3A44] transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
            Envoyer le lien
        </button>

        <!-- Back to Login -->
        <div class="text-center">
            <a href="{{ route('login') }}" 
               class="text-[#305F72]/70 hover:text-[#305F72] text-sm transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la connexion
            </a>
        </div>
    </form>
</x-guest-layout>
