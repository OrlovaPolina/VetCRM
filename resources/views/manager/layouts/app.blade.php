<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    <body class="font-sans antialiased">  
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')
            <header class="bg-white dark:bg-gray-800 shadow mb-100">
                <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
                    @include('layouts.manager-nav')
                </div>
                @if(isset($_GET['success']))
                <div class="alert alert-info position-absolute" role="alert">
                    Изменения сохранены!
                </div>
                @elseif(isset($_GET['error']))
                <div class="alert alert-warning position-absolute" role="alert">
                    Произошла ошибка, обратитесь к разработчикам!
                </div>
                @endif
            </header>
            <main>
                <?
                
                if(!isset($users) || $users == null){
                    $users = null;
                }
                ?>
                <x-manager-forms :user="$users" :search="$search"/>
            </main>
        </div>
    </body>
</html>