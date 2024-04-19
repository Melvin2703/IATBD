<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>
    <h1 class="text-3xl text-center p-6 mt-4">Plaats hier uw nieuwe post</h1>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-turquoise-main shadow-sm rounded-lg p-6">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"> 
                @csrf
                <div>
                    <x-input-label class="mt-4 text-lg text-grey-700" for="animal" :value="__('Wat voor een soort dier is het?')"/>
                    <x-input-select :options="$animals" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"/>
                </div>
                <input
                    name="message"
                    placeholder="{{ __('Wat is de naam van je huisdier?') }}"
                    class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                >
                <textarea
                    name="description"
                    placeholder="{{ __('Beschrijf uw huisdier in een aantal woorden') }}"
                    class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                >{{ old('description') }}</textarea>
                <input
                    name="price"
                    placeholder="{{ __('Prijs') }}"
                    class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2"
                    pattern="^\d*(\.\d{0,2})?$"
                    oninput="this.value = this.value.replace(/,/g, '.')"
                >
                <div class="flex mt-2">
                    <div class="mr-2 w-full">
                        <input
                            type="date"
                            name="start_date"
                            class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="date"
                            name="end_date"
                            class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm"
                        >
                    </div>
                </div>
                <x-input-label class="mt-2 text-lg text-gray-700" for="photo" :value="__('Voeg hier een foto van uw huisdier toe.')"/>
                <input type="file" id="photo" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2" name="image" accept="image/jpeg, image/png, image/jpg, image/gif" aria-label="Voer hier een foto van uw huisdier">
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                <x-primary-button class="mt-4">{{ __('Post') }}</x-primary-button>
            </form>
        </div>
        <h1 class="text-3xl text-center p-6 mt-4">Posts</h1>
        <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
            <details>
                <summary>
                    Filteren en sorteren
                </summary>
                <form id="filterForm" action="{{ route('posts.filter') }}" method="GET">
                    <div class="mt-2">
                        <label for="sort_by_date" class="block text-lg text-gray-700">Sorteer op datum:</label>
                        <select id="sort_by_date" name="sort" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2">
                            <option value="desc">Nieuwste eerst</option>
                            <option value="asc">Oudste eerst</option>
                        </select>
                        <div class="flex mt-2">
                            <div class="mr-2 w-full">
                                <label for="start_date_filter" class="block text-lg text-gray-700">Startdatum:</label>
                                <input type="date" id="start_date_filter" name="start_date_filter" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2">
                            </div>
                            <div class="w-full">
                                <label for="end_date_filter" class="block text-lg text-gray-700">Einddatum:</label>
                                <input type="date" id="end_date_filter" name="end_date_filter" class="block w-full bg-turquoise-base border-turquoise-base focus:border-turquoise-base focus:ring focus:ring-turquoise-base focus:ring-opacity-50 rounded-md shadow-sm mt-2">
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="end_date_filter" class="block text-lg text-gray-700">Prijs:</label>
                            <div id="price-slider" class="mt-2"></div>
                            <div id="price-values" class="mt-2"></div>
                            <input type="hidden" id="price-min" name="price_min">
                            <input type="hidden" id="price-max" name="price_max">
                        </div>
                        <x-primary-button type="submit" class="mt-4">
                            Filter
                        </x-primary-button>
                    </div>
                </form>
            </details>
        </div>
        @foreach ($posts as $post)
            <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                <div class="flex-1">
                    <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <div>
                            <a class="text-gray-800" href="{{ route('user.profile', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                        @if ($post->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('posts.edit', $post)">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('posts.destroy', $post)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @endif
                    </div>
                    <p class="mt-2 text-lg text-gray-900">Soort huisdier: {{ $post->animal }}</p>
                    <p class="text-lg text-gray-900">Naam: {{ $post->message }}</p>
                    <p class="text-lg text-gray-900">Beschrijving: {{ $post->description }}</p>
                    <p class="text-lg text-gray-900">Prijs per uur: €{{ $post->price }}</p>
                    <p class="text-lg text-gray-900">Startdatum: {{ $post->start_date->format('d M Y') }}</p>
                    <p class="text-lg text-gray-900">Einddatum: {{ $post->end_date->format('d M Y') }}</p>
                    <div class="flex-1 justify-center items-center">
                        @unless($post->image == null)
                            <img class="mt-2 w-full" src="{{ asset('storage/images/' . $post->image) }}" alt="Foto van het huisdier">
                        @endunless
                        @unless($post->video == null)
                            <video class="mt-2 w-full" controls>
                                <source src="{{ asset('storage/video/' . $post->video) }}"alt="Video van de woning" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endunless
                        @if ($post->user->isnot(auth()->user()))
                            @php
                                $requestExists = false;
                                if (auth()->check()) {
                                    $requestExists = App\Models\Aanvraag::where('post_id', $post->id)
                                                                        ->where('user_id_request', auth()->user()->id)
                                                                        ->exists();
                                }
                            @endphp
                            @if ($requestExists)
                                <form method="POST" action="{{ route('requests.destroy', ['user_id_request' => auth()->user()->id, 'post_id' => $post->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button class="mt-4" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Verzoek annuleren') }}</x-primary-button>
                                </form>
                            @endif
                            @if (!$requestExists)
                                <form method="POST" action="{{ route('requests.store', ['user_id_request' => auth()->user()->id, 'user_id_post' => $post->user_id, 'post_id' => $post->id]) }}">
                                    @csrf
                                    <x-primary-button class="mt-4">{{ __('Verzoek verzenden') }}</x-primary-button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>

<script>
    var priceSlider = document.getElementById('price-slider');
    var priceMin = document.getElementById('price-min');
    var priceMax = document.getElementById('price-max');
    var priceValues = document.getElementById('price-values');

    noUiSlider.create(priceSlider, {
        start: [0, 50],
        connect: true,
        range: {
            'min': 0,
            'max': 50
        }
    });

    priceSlider.noUiSlider.on('update', function (values, handle) {
        var value = values[handle];
        if (handle) {
            priceMax.value = value;
        } else {
            priceMin.value = value;
        }
        updatePriceValues();
    });

    function updatePriceValues() {
        var minPrice = priceMin.value;
        var maxPrice = priceMax.value;
        priceValues.innerHTML = 'Min prijs: €' + minPrice + ' - Max prijs: €' + maxPrice;
    }
</script>