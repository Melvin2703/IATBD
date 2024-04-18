<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-turquoise-base" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-turquoise-base" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label class="mt-2 text-lg text-gray-700" for="photo" :value="__('Voeg hier een foto van uw huis toe.')"/>
            <input type="file" id="photo" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" name="image" accept="image/jpeg, image/png, image/jpg, image/gif">
        </div>

        <div>
            <x-input-label class="mt-2 text-lg text-gray-700" for="video" :value="__('Voeg hier een video van uw huis toe.')"/>
            <input type="file" id="video" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" name="video" accept="video/*">
        </div>                
                <script>
                document.querySelector('form').addEventListener('submit', function(event) {
                    const photoInput = document.getElementById('photo');
                    const videoInput = document.getElementById('video');

                    if (photoInput.files.length > 0) {
                        const photoExtension = photoInput.files[0].name.split('.').pop().toLowerCase();
                        if (!['jpeg', 'jpg', 'png', 'gif'].includes(photoExtension)) {
                            event.preventDefault();
                            alert('Fout: Ongeldig bestandstype voor foto. Toegestane types zijn: JPEG, JPG, PNG, GIF');
                            return;
                        }
                    }
                
                    if (videoInput.files.length > 0) {
                        const videoExtension = videoInput.files[0].name.split('.').pop().toLowerCase();
                        if (!['mp4', 'avi', 'mov', 'wmv'].includes(videoExtension)) {
                            event.preventDefault();
                            alert('Fout: Ongeldig bestandstype voor video. Toegestane types zijn: MP4, AVI, MOV, WMV');
                            return;
                        }
                    }
                });
                </script>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
