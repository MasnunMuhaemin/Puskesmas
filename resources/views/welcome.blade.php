<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans text-center">
        <p class="text-primary font-bold text-5xl">Test Warna Primary</p>
        <p class="text-slate-600 mt-4 text-xl">Font Plus Jakarta Sans Sudah Aktif</p>
    </body>
</html>

