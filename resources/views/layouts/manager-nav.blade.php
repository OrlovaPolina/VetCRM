<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
    {{auth()->user()->name}}
</h2>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link @if(Route::currentRouteName() == 'manager.dashboard') active @endif"  @if(Route::currentRouteName() == 'manager.dashboard') 
        aria-current="page"
        @endif href="/manager">Пользователи</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::currentRouteName() == 'manager.timetable') active @endif"   @if(Route::currentRouteName() == 'manager.timetable') 
        aria-current="page"
        @endif href="/manager/timetable">Расписание</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Route::currentRouteName() == 'manager.news') active  @endif"  @if(Route::currentRouteName() == 'manager.news') 
        aria-current="page"
        @endif href="/manager/news?type=news">Новости/Акции</a>
    </li>
</ul>