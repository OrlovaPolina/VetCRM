<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
        'resources/css/app.css',   
        'resources/css/app.scss',   
        'resources/css/public.scss',  
        'resources/js/app.js',          
        ])
        {{-- <script src="js/fullCalendar/index.global.js"></script> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen container-main">
            @include('layouts.navigation')
            @if(!isset($user_sub))
            <div class="user-sub">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <x-user-sub-nav></x-user-sub-nav>
                </div>
            </div>
            @endif
            @auth
                @if(Auth::user()->role === '2')
                <div class="user-sub">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @include('layouts.manager-nav')
                </div>
                @endif
            @endauth
