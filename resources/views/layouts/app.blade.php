<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="Solon">
        <meta name="description" content="{{$metaDescription}}">

        <title>{{ $metaTitle ?: config('app.name', 'Laravel')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{url('icons/favicon.ico')}}" sizes="any">
        <link rel="icon" href="{{url('icons/favicon.svg')}}" type="image/svg+xml">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        @livewireScripts
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" >
        <x-banner />
        @include('layouts.partials.header')
        @yield('hero')
        <main class="container mx-auto px-5 flex flex-grow">
            {{$slot}}
        </main>
        @include('layouts.partials.footer')
        @stack('modals')
    </body>
</html>
