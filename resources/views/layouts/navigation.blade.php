<header>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 container-box">
            <div class="flex logo-box">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </div>           
                <ul class="nav menu">
                    @if(Route::currentRouteName() !== 'home')
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link">
                                Главная
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('news')}}">
                            Новости
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('stocks')}}">
                            Акции
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about')}}">
                            О нас
                        </a>
                    </li>
                    @auth
                        @if (Auth::user()->role === '0')
                        <li class="nav-item">                            
                            <a class="nav-link" href="{{route('user.createEventPage')}}">
                                Записаться на приём
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>                         
            @auth
            <div class="drop-user sm:flex sm:items-center sm:ml-6 ">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            {{mb_substr(Auth::user()->name,0,10) }}.
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Профиль
                        </x-dropdown-link>
                        @if (isset(auth()->user()->role))
                            @if(intval(auth()->user()->role) == 0)
                            <x-dropdown-link :href="route('user.animals')">                           
                                    Личный кабинет
                            </x-dropdown-link>  
                            @elseif(intval(auth()->user()->role) == 1)
                            <x-dropdown-link :href="route('doctor.events')">                           
                                Личный кабинет
                            </x-dropdown-link>  
                            @endif
                        @endif        
                        @if (isset(auth()->user()->role))
                            @if(intval(auth()->user()->role) == 2)
                                <x-dropdown-link :href="route('manager.dashboard')">
                                    Админ. Панель
                                </x-dropdown-link>
                            @endif
                        @endif
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            Выйти
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                        @auth                            
                        @else
                            <a href="{{ route('login') }}" class="login-link auth-link">
                                Войти
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="register_link auth-link">
                                    Регистрация
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            @endif
        </div>
    </div>
</header>
