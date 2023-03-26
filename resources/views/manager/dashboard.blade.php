<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{auth()->user()->name}}
        </h2>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/manager">Пользователи</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/manager/timetable">Расписание</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/manager/news">Новости</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/manager/stock">Акции</a>
            </li>
        </ul>
    </x-slot>
</x-manager-layout>