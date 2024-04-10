<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <h3 class="font-semibold text-2xl text-gray-700">Sign Up</h3>
        </div>

        <!-- Name -->
        <div class="mt-6">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-pink-accent hover:text-pink-accent-hover rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
