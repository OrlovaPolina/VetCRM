<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/app.js', 'resources/css/app.scss',
            'resources/js/calendar.js'])
        <script src="js/fullCalendar/index.global.js"></script>
    </head>
    <body class="font-sans antialiased">  
        <style>         
    .fc-popover{
        background-color: rgb(51, 51, 51) !important
    }
        </style>
        <div class="min-h-screen container-main">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <div class="user-sub">
                <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
    </body>
</html>
