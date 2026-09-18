<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LA RANA EXPRESS') }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}?v=rana">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-[#F7F8F4]">
    <div class="flex min-h-screen md:h-screen md:overflow-hidden">
        <aside class="relative hidden md:flex md:w-1/2 items-center justify-center bg-[#14351D] p-8 lg:p-12">
            <img src="{{ asset('img/imagen_login.jpg') }}?v=rana"
                 alt="{{ config('app.name', 'LA RANA EXPRESS') }}"
                 class="max-h-full max-w-full w-auto h-auto object-contain rounded-2xl bg-white shadow-2xl">
        </aside>

        <main class="flex flex-col items-center justify-center w-full px-4 py-10 overflow-y-auto md:w-1/2 bg-white">
            <a href="{{ url('/') }}" title="{{ config('app.name', 'LA RANA EXPRESS') }}" class="mb-6">
                <img src="{{ asset('img/logo01.png') }}?v=rana"
                     alt="{{ config('app.name', 'LA RANA EXPRESS') }}"
                     class="h-20 w-auto max-w-[280px] object-contain">
            </a>

            <div class="w-full max-w-sm px-6 py-7 bg-white border border-gray-200 shadow-xl rounded-2xl">
                {{ $slot }}
            </div>

            <div class="w-full max-w-sm mt-6 text-sm text-center text-gray-500">
                <p>Versión v3.0.0</p>
                <p class="mt-1">© {{ date('Y') }} <a href="https://open9.cloud" target="_blank"
                   class="font-medium text-[#2F6B32] hover:underline">OPEN9</a></p>
            </div>
        </main>
    </div>
</body>

</html>
