<x-app-layout>
    @if (!auth()->user()->is_admin)
            @abort (403, 'You are not authorized to view this page')
    @else
        <h1 class="text-3xl text-center p-6">All current users</h1>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            @foreach($users as $user)
                <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                    <div class="card-body flex-1">  
                        <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent">
                            <h5 class="card-title text-xl font-bold">{{ $user->name }} </h5>
                            <p class="card-text text-gray-600">{{ $user->email }}</p>
                        </div>
                        @if ($user->id != auth()->user()->id && !$user->is_admin)
                        <div class="mt-4 flex">
                            <div class="mx-4 px-4 py-2 rounded-md">
                                @if($user->is_blocked)
                                    <a href="/admin/{{$user->id}}/block">unblock user</a>
                                @else
                                    <a href="/admin/{{$user->id}}/block">block user</a>
                                @endif
                            </div>
                            <div class="mx-4 px-4 py-2 rounded-md">
                                @if($user->is_admin)
                                    <a href="/admin/{{$user->id}}/admin">remove admin</a>
                                @else
                                    <a href="/admin/{{$user->id}}/admin">make admin</a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <h1 class="text-3xl text-center p-6">All posts</h1>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        @foreach ($posts as $post)
            <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                <div class="flex-1">
                    <div class="flex justify-between items-center py-1 border-b-2 border-beige-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a') }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
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
                    </div>
                    <p class="mt-2 text-lg text-gray-900">Soort huisdier: {{ $post->animal }}</p>
                    <p class="text-lg text-gray-900">Naam: {{ $post->message }}</p>
                    <p class="text-lg text-gray-900">Beschrijving: {{ $post->description }}</p>
                    <p class="text-lg text-gray-900">Prijs per uur: €{{ $post->price }}</p>
                    <p class="text-lg text-gray-900">Startdatum: {{ $post->start_date->format('d M Y') }}</p>
                    <p class="text-lg text-gray-900">Einddatum: {{ $post->end_date->format('d M Y') }}</p>
                    @unless($post->image == null)
                        <img class="mt-2" src="{{ asset('storage/images/' . $post->image) }}" alt="Animal Image">
                    @endunless
                </div>
            </div>
        @endforeach
    </div>
    @endif
</x-app-layout>