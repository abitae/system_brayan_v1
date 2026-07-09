<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/logo01.ico') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Image section - visible on medium screens and up -->
        <div class="hidden bg-white md:flex md:w-1/2 lg:w-2/3">
            <img src="{{ asset('img/imagen_login.jpg') }}" alt="{{ config('app.name', 'INFINITY-CARGO') }}"
                 class="object-cover w-full h-full transition-opacity duration-300 hover:opacity-95">
        </div>

        <!-- Login form section -->
        <div class="flex flex-col items-center justify-center w-full p-4 bg-white md:w-1/2 lg:w-1/3">
            <!-- Logo -->
            <div class="mt-4 mb-6 transition-transform duration-300 md:mt-0 hover:scale-105">
                <a href="/" title="{{ config('app.name', 'INFINITY-CARGO') }}">
                    <img src="{{ asset('img/logo01.png') }}" alt="{{ config('app.name', 'INFINITY-CARGO') }}" class="h-16 md:h-20">
                </a>
            </div>

            <!-- Form container -->
            <div class="w-full max-w-md px-6 py-8 mx-auto bg-white border border-gray-500 shadow-2xl rounded-xl">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="w-full max-w-md mt-8 mb-4 text-sm text-center text-gray-500">
                <p>Versión v3.0.0</p>
                <p class="mt-1">© {{ date('Y') }} <a href="https://open9.cloud" target="_blank"
                   class="font-medium text-green-600 transition-colors hover:text-green-800 hover:underline">OPEN9</a></p>
            </div>
        </div>
    </div>
</body>

</html>
