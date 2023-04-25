@include('layouts.header')
<main>
    <x-user-events-list :events="$events" :visits="$visits"/>
</main>
@include('layouts.footer')