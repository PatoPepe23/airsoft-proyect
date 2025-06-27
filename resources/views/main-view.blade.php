@php
    $config = [
        'appName' => config('app.name'),
        'locale' => $locale = app()->getLocale(),
        'locales' => config('app.locales'),
    ];
@endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dunkerque Airsoft Camp</title>

    {{-- CORRECTED: Use Laravel's asset() helper for public assets --}}
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script>
        window.config = @json($config);
    </script>
    {{-- This is correct for Vite. It handles dev vs. prod automatically. --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased" id="app">
<router-view></router-view>
</body>
</html>
