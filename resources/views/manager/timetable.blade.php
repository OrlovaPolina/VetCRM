@include('layouts.head')
@include('layouts.navigation')
<div class="user-sub">
    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
    @include('layouts.manager-nav')
    </div>
</div>
@if (isset($error) || isset($_GET['error']))
<div class="z-3 alert alert-warning position-absolute" role="alert">
   Произошла ошибка <br/>
   Попробуйте ещё раз
</div>
@endif
@if (isset($success) || isset($_GET['success']))
<div class="z-3 alert alert-success position-absolute" role="alert" style="top: 65px;">
    Запись успешно удалена!
</div>
@endif
<main>
    <ul id="current-schedule" class="d-none">                                   
        @foreach ($events as $key=>$item)    
        @php
            $start = $item['start'];
            $end = $item['end'];
        @endphp
        <li data-start="{{$start}}" data-end="{{$end}}" data-url="{{$item['id']}}"
        data-title="{{$item->doctor->name}}"></li>                
        @endforeach
    </ul>
    <div id="calendar-curent-schedule">

    </div>
</main>
<script src="/js/fullCalendar/index.global.js"></script>
<script src="/js/fullcalendar-6.1.6/fullcalendar-6.1.6/packages/core/locales-all.global.min.js"></script>
@vite(['resources/js/manager.js'])
@include('layouts.footer')