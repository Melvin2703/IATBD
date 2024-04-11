<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Registreren -->
        <div>
            <h3 class="font-semibold text-2xl text-gray-700">Inloggen</h3>
            <p class="text-gray-500">Geen account? <a class="underline text-sm text-pink-accent hover:text-pink-accent-hover rounded-md" href="{{ route('register') }}">Registreren</a></p>
        </div>

        <!-- Email Address -->
        <div class="mt-6 text-gray-700">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 text-gray-700">
            <x-input-label for="password" :value="__('Wachtwoord')" />

            <x-text-input id="password" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-turquoise-base shadow-sm focus:ring-turquoise-base" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Onthoud mij') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-pink-accent hover:text-pink-accent-hover rounded-md" href="{{ route('password.request') }}">
                    {{ __('Wachtwoord vergeten?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Inloggen') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
