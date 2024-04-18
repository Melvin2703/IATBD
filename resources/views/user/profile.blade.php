<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl text-center p-6">Gebruikersprofiel</h1>
        <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
            <div class="flex-1">
                <div class="text-gray-700 text-lg ">
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
        <h1 class="mt-6 text-3xl text-center p-6">Reviews van deze gebruiker</h1>
        @if ($averageRating !== null)
            <div class="mb-6">
                <p class="text-center">Gemiddelde score: {{ number_format($averageRating, 1) }}</p>
            </div>
        @endif
        @foreach ($user->reviews as $review)
            <div class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6">
                <div class="flex-1">
                    <div class="text-gray-700 text-lg">
                        <p>Rating: {{ $review->rating }}</p>
                        <p>Review: {{ $review->comment }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($user->reviews->isEmpty())
            <p class="mt-6 bg-turquoise-main shadow-sm rounded-lg p-6 text-gray-700 text-lg">Deze gebruiker heeft nog geen reviews ontvangen.</p>
        @endif
        </div>
    </div>
</x-app-layout>
