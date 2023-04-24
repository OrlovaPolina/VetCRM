<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold">
           {{auth()->user()->name}}
        </h2>
        
    </x-slot>
</x-app-layout>
