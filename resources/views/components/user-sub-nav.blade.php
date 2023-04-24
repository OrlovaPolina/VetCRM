@auth
    <ul class="nav nav-tabs">
        @if(Auth::user()->role == 0)           
            <li class="nav-item">
                <a class="nav-link  @if(Route::currentRouteName() == 'user.animals')  active @endif"
                @if(Route::currentRouteName() == 'user.animals') 
                aria-current="page"
                @endif
                    href="/user/animals">Животные</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  @if(Route::currentRouteName() == 'user.events')  active @endif"
                @if(Route::currentRouteName() == 'user.events') 
                aria-current="page"
                @endif
                    href="/user/events">Приёмы</a>
            </li>
        @elseif(Auth::user()->role == 1)
        <li class="nav-item">
            <a class="nav-link  @if(Route::currentRouteName() == 'doctor.events')  active @endif"
            @if(Route::currentRouteName() == 'doctor.events') 
            aria-current="page"
            @endif
                href="/doctor/timeboard">Расписание</a>
        </li>
        @endif            
    </ul>
@endauth