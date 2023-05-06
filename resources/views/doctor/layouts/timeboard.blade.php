@include('layouts.header')
@if (isset($error) || isset($_GET['error']))
<div class="z-3 alert alert-warning position-absolute" role="alert">
   Произошла ошибка <br/>
   Попробуйте ещё раз
</div>
@endif
@if (isset($success) || isset($_GET['success']))
<div class="z-3 alert alert-success position-absolute" role="alert" style="top: 65px;">
    Запись создана
</div>
@endif
@if (isset($success_error) || isset($_GET['success_error']))
<div class="z-3 alert alert-warning position-absolute" role="alert" style="top: 65px;">
    Запись Не создана
</div>
@endif
@if (isset($success_reAd) || isset($_GET['success_reAd']))
<div class="z-3 alert alert-success position-absolute" role="alert" style="top: 125px;">
    Повторная запись создана успешно
</div>
@endif
@if (isset($success_reAd_error) || isset($_GET['success_reAd_error']))
<div class="z-3 alert alert-warning position-absolute" role="alert" style="top: 125px;">
    Повторная запись Не успешно
</div>
@endif
@if (isset($vaccinations) || isset($_GET['vaccinations']))
<div class="z-3 alert alert-success position-absolute" role="alert" style="top: 184px;">
    Запись о вакцинации успешно создана
</div>
@endif
@if (isset($vaccinations_error) || isset($_GET['vaccinations_error']))
<div class="z-3 alert alert-warning position-absolute" role="alert" style="top: 184px;">
    Запись о вакцинации Не создана
</div>
@endif
<main class="d-flex position-relative">
    <ul id="current-schedule" class="d-none">                                   
        @foreach ($events as $key=>$item)           
        <?
        
        // echo '<pre>' .json_encode($item['start']).'</pre>';?>                       
        {{-- @foreach ($item as $k=>$value)       --}}
        @php
        // if($key == 'start')
            $start = $item['start'];
        // if($key == 'end')
            $end = $item['end'];
        @endphp
        <li data-start="{{$start}}" data-end="{{$end}}" data-url="{{$item['id']}}">{{$item->user->name}}</li>
                                                
        {{-- @endforeach --}}
                                                
        @endforeach
    </ul>
    <div id="calendar-curent-schedule">

    </div>
</main>
<script src="/js/fullCalendar/index.global.js"></script>
<script src="/js/fullcalendar-6.1.6/fullcalendar-6.1.6/packages/core/locales-all.global.min.js"></script>
@vite(['resources/js/doctor.js'])
@include('layouts.footer')