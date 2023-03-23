<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{auth()->user()->name}}
        </h2>
    </x-slot>
</x-manager-layout>