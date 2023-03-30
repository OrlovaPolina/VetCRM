<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Manager</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/manager.scss',
            'resources/js/app.js',
            'resources/js/app.js',
            'resources/css/app.scss',
            'resources/js/manager.js',
           ])
    </head>
    <body>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        