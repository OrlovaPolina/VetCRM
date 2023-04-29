<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="/js/fullCalendar/index.global.js"></script>
        <script src="/js/fullcalendar-6.1.6/fullcalendar-6.1.6/packages/core/locales-all.global.min.js"></script>

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/manager.scss',
            'resources/js/app.js',
            'resources/js/app.js',
            'resources/css/app.scss',
            'resources/js/manager.js',
           ])
           <style>
            .container-main{
                margin-bottom: 500px;
            }
           </style>
</head>
<body class="font-sans antialiased">  
    <div class="min-h-screen container-main">
        @include('layouts.navigation')
        <div class="user-sub">
            <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
                @include('layouts.manager-nav')
            </div>
            @if(isset($_GET['success']) || isset($success))
            <div class="alert alert-info position-absolute" role="alert">
                Изменения сохранены!
            </div>
            @elseif(isset($_GET['error']) || isset($error))
            <div class="alert alert-warning position-absolute" role="alert">
                Произошла ошибка, обратитесь к разработчикам!
            </div>
            @endif
        </div>
        <main class="d-flex position-relative w-100">
              
                <h2>{{$doctor->name}}</h2>
                <button 
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#createSchedule"
                aria-expanded="false"
                aria-controls="createSchedule"
                class="btn btn-success createSchedule">Создать график на следующий месяц</button>

                <br>
                <form id="createSchedule" class="collapse create-schedule-form flex-column justify-content-between" action="" method="post">
                    @csrf
                    <input type="hidden" name="doctor" value="{{$doctor->id}}">
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" name="week[1]" id="btncheck1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck1">Понедельник</label>                      
                        <input type="checkbox" class="btn-check" name="week[2]" id="btncheck2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck2">Вторник</label>                      
                        <input type="checkbox" class="btn-check" name="week[3]" id="btncheck3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck3">Среда</label>
                        <input type="checkbox" class="btn-check" name="week[4]" id="btncheck4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck4">Четверг</label>
                        <input type="checkbox" class="btn-check" name="week[5]" id="btncheck5" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck5">Пятница</label>
                        <input type="checkbox" class="btn-check" name="week[6]" id="btncheck6" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck6">Суббота</label>
                        <input type="checkbox" class="btn-check" name="week[0]" id="btncheck0" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck0">Воскресенье</label>
                    </div>
                    <select required class="form-select" name="hours" aria-label="Default select example">
                        <option value="" disabled selected hidden >Выберите Время выделенное на приём</option>
                        <option value="20">20 минут</option>
                        <option value="30">30 минут</option>
                        <option value="60">60 минут</option>
                      </select>
                      <button class="btn btn-success" type="submit">Создать</button>
                </form>
                <br>
                <h3>График работы</h3>
                <ul id="current-schedule" class="d-none">                                   
                    @foreach ($schedule as $key=>$item)
                    @php
                    @endphp                                    
                        @foreach ($item as $k=>$i)
                        @php
                            $start =$key. " ".$i['start'];
                            $end =$key . " ".$i['end'];
                        @endphp
                        <li data-start="{{$start}}" data-end="{{$end}}">{{$start. " - ".$end}}</li>
                        @endforeach                                       
                    @endforeach
                </ul>
                <div id="calendar-curent-schedule">

                </div>
        </main>
        
        @include('layouts.footer')
    </div>
    
</body>
</html>