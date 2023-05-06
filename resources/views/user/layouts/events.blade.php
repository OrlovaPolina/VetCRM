@include('layouts.header')
<main>
    <x-user-events-list :events="$events" :visits="$visits"/>
</main>
@vite([       
    'resources/js/user.js',  
])
@include('layouts.footer')