<x-app-layout>
    @if (!auth()->user()->is_admin)
            @abort (403, 'You are not authorized to view this page')
    @else
        <h1 class="text-3xl text-center p-6">All current users</h1>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            @foreach($users as $user)
                <div class="bg-white rounded-lg p-4 mb-4 shadow-md border-2 flex items-center w-full">
                    <div class="card-body">  
                        <h5 class="card-title text-xl font-bold">{{ $user->name }} </h5>
                        <p class="card-text text-gray-600">{{ $user->email }}</p>
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
                    </div>
                </div>
            @endforeach
        </div>

        <h1 class="text-3xl text-center p-6">All chirps</h1>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            @foreach($chirps as $chirp)
            <div class="bg-white rounded-lg p-4 mb-4 shadow-md border-2 flex items-center w-full">
                <div>
                    <div class="flex items-center mb-2">
                        @if(auth()->user()->image)
                            <div class="rounded-full h-8 w-8 bg-gray-300 mr-2">
                                <img src="{{ auth()->user()->image }}" alt="User Image" class="rounded-full h-8 w-8">
                            </div>
                        @else
                            <div class="rounded-full h-8 w-8 bg-gray-300 mr-2"></div>
                        @endif
                        <h4 class="text-lg font-semibold">{{ $chirp->dog_name }}</h4>
                        <span class="text-gray-400 text-sm mx-2">{{ $chirp->created_at->diffForHumans(['short' => true]) }}</span>
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                    </div>
                    <p class="mt-2 text-lg text-gray-900">Soort huisdier: {{ $chirp->animal }}</p>
                    <p class="text-lg text-gray-900">Naam: {{ $chirp->message }}</p>
                    <p class="text-lg text-gray-900">Beschrijving: {{ $chirp->description }}</p>
                    @unless($chirp->image == null)
                        <img class="mt-2" src="{{ asset('storage/images/' . $chirp->image) }}" alt="Animal Image">
                    @endunless
                    @unless($chirp->video == null)
                    <video class="mt-2" controls>
                        <source src="{{ asset('storage/video/' . $chirp->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @endunless
                </div>
            </div>
            @endforeach
        </div>
    @endif
</x-app-layout>