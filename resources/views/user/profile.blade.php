<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
            <div class="flex-1">
                <div class="text-gray-700 text-lg flex justify-between items-center py-1 border-b-2 border-beige-accent">
                    <h2>Gebruikersprofiel</h2>
                </div>
                <div class="text-gray-700 mt-2 text-lg ">
                    <p>Naam: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Actief sinds: {{ $user->created_at->format('M Y')}} 
                    @unless($user->image == null)
                        <img class="mt-2 w-full" src="{{ asset('storage/images/' . $user->image) }}" alt="Foto van het huis van de gebruiker">
                    @endunless
                    @unless($user->video == null)
                        <video class="mt-2 w-full" controls>
                            <source src="{{ asset('storage/video/' . $user->video) }}"alt="Video van het huis van de gebruiker" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
