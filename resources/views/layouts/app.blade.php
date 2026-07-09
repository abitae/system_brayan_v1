<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INFINITY-CARGO v3.0') }}</title>
    <link rel="icon" href="img/logo01.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@2.9.6/build/vanilla-calendar.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- It will not apply locale yet --}}
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        flatpickr.localize(flatpickr.l10ns.es);
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen font-sans antialiased bg-base-200/40">
    @include('components.partials.header')
    @include('components.partials.sidebar')
    <x-mary-toast />
    <x-mary-spotlight />
</body>
</html>
