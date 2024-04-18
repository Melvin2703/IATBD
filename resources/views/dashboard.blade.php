<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl text-center p-6">Uw posts</h1>
            @foreach($posts as $post)
                @if ($post->user->id === auth()->id())
                    <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                        <div class="flex-1">
                            <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <div>
                                    <span class="text-gray-700">{{ $post->user->name }}</span>
                                    <small class="ml-2 text-sm text-gray-700">{{ $post->created_at->format('j M Y, g:i a') }}</small>
                                    @unless ($post->created_at->eq($post->updated_at))
                                        <small class="text-sm text-gray-700"> &middot; {{ __('edited') }}</small>
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
                            <div>
                                <p class="mt-2 text-lg text-gray-900">Soort huisdier: {{ $post->animal }}</p>
                                <p class="text-lg text-gray-900">Naam: {{ $post->message }}</p>
                                <p class="text-lg text-gray-900">Beschrijving: {{ $post->description }}</p>
                                @unless($post->image == null)
                                    <img class="mt-2" src="{{ asset('storage/images/' . $post->image) }}" alt="Animal Image">
                                @endunless
                                @unless($post->video == null)
                                    <video class="mt-2" controls>
                                        <source src="{{ asset('storage/video/' . $post->video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endunless
                            </div>
                            <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent"></div>
                            <div class="mt-2">
                                <h1 class="text-gray-700 text-lg">Uw ontvangen aanvragen:</h1>
                                @foreach($aanvragen->where('post_id', $post->id) as $aanvraag)
                                    @php
                                        $user = App\Models\User::find($aanvraag->user_id_request);
                                    @endphp
                                    @if($user)
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('user.profile', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                            @if($aanvraag->accepted == 0)
                                                <form method="POST" action="{{ route('update.accepted', ['id' => $aanvraag->id, 'accepted' => 1]) }}">
                                                    @csrf
                                                    @method('GET')
                                                    <x-primary-button class="mt-2" type="submit">Accepteren</x-primary-button>
                                                </form>
                                            @elseif($aanvraag->accepted == 2)
                                                <x-primary-button class="mt-2" type="submit">Afgewezen</x-primary-button>
                                            @else
                                                <x-primary-button class="mt-2" type="submit">Geaccepteerd</x-primary-button>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                                <div>
                                    @foreach($aanvragen->where('post_id', $post->id) as $aanvraag)
                                        @php
                                            $user = App\Models\User::find($aanvraag->user_id_request);
                                        @endphp
                                        @if($aanvraag->accepted == 1)
                                            <x-primary-button class="mt-2" type="submit">Review {{ $user->name }}</x-primary-button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <h1 class="text-3xl text-center p-6">Uw verzonden aanvragen</h1>
            @foreach($aanvragen as $aanvraag)
                @if ($aanvraag->user_id_request == auth()->user()->id)
                    <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                        <div class="flex-1">
                            <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent">
                                <div>
                                    <small class="ml-2 text-sm text-gray-700">{{ $aanvraag->created_at->format('j M Y, g:i a') }}</small>
                                </div>
                            </div>
                            @php
                                $user = App\Models\User::find($aanvraag->user_id_post);
                            @endphp
                            @if($user)
                                <p class="mt-2 text-lg text-gray-700">Aanvraag verzonden naar: <a href="{{ route('user.profile', ['id' => $user->id]) }}">{{ $user->name }}</a></p>  
                                <p class="text-lg text-gray-700">
                                    Status: 
                                    @if($aanvraag->accepted == 1)
                                        Goedgekeurd
                                    @elseif($aanvraag->accepted == 2)
                                        Afgewezen
                                    @else
                                        In behandeling
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>