<x-app-layout>
    <script src="{{ asset('js/app.js') }}"></script>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div>
                    <x-input-label class="mt-1" for="animal" :value="__('soort dier')"/>
                    <x-input-select :options="$animals" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"/>
                </div>
                <input
                    name="message"
                    class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                    value="{{ old('message', $post->message) }}">
                <textarea
                    name="description"
                    class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"                >{{ old('description', $post->description) }}</textarea>
                <input type="file" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" name="image" accept="jpeg,png,jpg,gif">
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <div class="mt-4 space-x-2">
                    <x-primary-button>{{ __('Opslaan') }}</x-primary-button>
                    <a class="underline text-xl text-pink-accent hover:text-pink-accent-hover rounded-md" href="{{ route('posts.index') }}">{{ __('Annuleer') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>