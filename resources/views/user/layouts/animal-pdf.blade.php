<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Карточка животного {{date('Y-m-d')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style>
           *,p,h1,h2,h3,h4,h5,span,div{
                font-family:'dejavu serif';
            }
        </style>
        <!-- Scripts -->
        @vite([
        'resources/css/app.css',   
        'resources/css/app.scss',   
        // 'resources/css/public.scss',
        'resources/css/pdf.scss'
        ])
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
<body>
    <div class="container mt-5 d-flex flex-column">
        <div class="d-flex justify-center flex-column align-items-center logo-container">
            <div><img src="{{asset('vetpng.png')}}" id="logoPng" alt=""></div>
            <h1 class="text-center">VETCRM</h1>
        </div>
        <h2><p>{{Auth::user()->name}}</p></h2>
        <h2>
            <p>{{$animal_name->name}} - {{$animal_name->species->name}}</p>
        </h2>
        <div class="animal-box container-fluid d-flex position-relative w-100 p-10 flex-column">    
            @if(isset($events))
            @if(count($events)>=0)
            @php
                $count = 1;
            @endphp
            @foreach ($events as $event)            
                <div class="events d-flex position-relative w-90 start-50 translate-middle-x flex-column">                            
                            <div class="d-flex header w-100 justify-content-between">
                                <div># {{$count}}</div>
                                <div>{{$event->title}}</div>
                                <div>{{$event->start}}</div>
                            </div>
                            <div class="d-grid">
                                <div class="d-flex">
                                    <div class="name">Температура: </div>
                                    <div class="value">
                                        @if(($visits->where('event_id',$event->id)->first()))
                                        <p>{{$visits->where('event_id',$event->id)->first()->temp}} &#xb0;С</p>
                                        @else
                                        Приёма ещё не было
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="name">Вес: </div>
                                    <div class="value">
                                        @if(($visits->where('event_id',$event->id)->first()))
                                        <p> {{$visits->where('event_id',$event->id)->first()->weight}} кг</p>
                                        @else
                                        Приёма ещё не было
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="name">Жалобы: </div>
                                    <div class="value">
                                        @if(($visits->where('event_id',$event->id)->first()))
                                        <p>{{$visits->where('event_id',$event->id)->first()->complaints}}</p>
                                        @else
                                        Приёма ещё не было
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="name">Осмотр: </div>
                                    <div class="value">
                                        @if(($visits->where('event_id',$event->id)->first()))
                                        <p>{{$visits->where('event_id',$event->id)->first()->inspection}}</p>
                                        @else
                                        Приёма ещё не было
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="name">Лечение: </div>
                                    <div class="value">
                                        @if(($visits->where('event_id',$event->id)->first()))
                                        <p>{{$visits->where('event_id',$event->id)->first()->therapy}}</p>
                                        @else
                                        Приёма ещё не было
                                        @endif
                                    </div>
                                </div>
                            </div>
                </div>
                @php
                     $count++;
                @endphp
            @endforeach
            @endif
            @endif
        </div>
@vite([       
'resources/js/user.js',  
])
</body>
</html>