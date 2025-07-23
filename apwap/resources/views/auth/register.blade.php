<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('Join APWAP') }}</h2>
        <p class="mt-2 text-sm text-gray-600">{{ __('Premium Pet Care in Dubai') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" placeholder="+971 50 123 4567" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">{{ __('For emergency contact and appointment reminders') }}</p>
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />
            <select id="city" name="city" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="Dubai" {{ old('city') == 'Dubai' ? 'selected' : '' }}>{{ __('Dubai') }}</option>
                <option value="Abu Dhabi" {{ old('city') == 'Abu Dhabi' ? 'selected' : '' }}>{{ __('Abu Dhabi') }}</option>
                <option value="Sharjah" {{ old('city') == 'Sharjah' ? 'selected' : '' }}>{{ __('Sharjah') }}</option>
                <option value="Ajman" {{ old('city') == 'Ajman' ? 'selected' : '' }}>{{ __('Ajman') }}</option>
            </select>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Language Preference -->
        <div class="mt-4">
            <x-input-label for="preferred_language" :value="__('Preferred Language')" />
            <select id="preferred_language" name="preferred_language" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="en" {{ old('preferred_language') == 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                <option value="fr" {{ old('preferred_language') == 'fr' ? 'selected' : '' }}>{{ __('Français') }}</option>
                <option value="ar" {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>{{ __('العربية') }}</option>
            </select>
            <x-input-error :messages="$errors->get('preferred_language')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
