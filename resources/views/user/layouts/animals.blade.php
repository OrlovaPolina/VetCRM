@include('layouts.header')
<main>
    <x-user-animals-list :animals="$animals" :events="$events" :visits="$visits"/>
    <div class="btn-box btn-add d-flex justify-content-evenly position-relative top-50 start-50 translate-middle-x">
        <i class="bi bi-plus-circle"></i>
        <a href="{{route('user.animalsCreatePage')}}">Добавить животное</a>
    </div>
</main>
@vite([       
    'resources/js/user.js',  
])
@include('layouts.footer')