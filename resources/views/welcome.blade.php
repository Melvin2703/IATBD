<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')

        <title>PassenOpJeDier</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>
<body class="">
        <div class="">
            @if (Route::has('login'))
                <div class="h-screen w-screen flex justify-center items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="h-20 w-64 bg-blue-600 text-white flex justify-center rounded-xl items-center mr-5 text-3xl hover:bg-[#00008B]">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="h-20 w-64 bg-blue-600 text-white flex justify-center rounded-xl items-center ml-5 text-3xl hover:bg-[#00008B]">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </body> 
</html>