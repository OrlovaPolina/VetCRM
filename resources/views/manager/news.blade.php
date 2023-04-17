@include('layouts.head')
@include('layouts.navigation')
<header class="bg-white dark:bg-gray-800 shadow mb-100">
    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
    @include('layouts.manager-nav')
    </div>
</header>
<main>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <form action="" method="get">
                <input type="hidden" name="type" value="news" >
                <a class="nav-link" onclick="event.preventDefault();
                this.closest('form').submit();">
                    Новости
                </a>
            </form>
        </li>
        <li class="nav-item">
            <form action="" method="get">
                <input type="hidden" name="type" value="stocks">
                <a class="nav-link" onclick="event.preventDefault();
                this.closest('form').submit();">
                    Акции
                </a>
            </form>
        </li>
        <li class="nav-item">
            <form action="{{route('manager.newsCreate')}}" method="get">
                <input type="hidden" name="type" value="stocks">
                <a class="nav-link" onclick="event.preventDefault();
                this.closest('form').submit();">
                    Создать
                </a>
            </form>
        </li>
    </ul>

    <?
    // $a = App\Models\News::where('id',1)->delete();
    // // $a = $a->history();
    // echo '<pre>' . print_r($a, 1) . '</pre>';
    ?>
    @if(isset($_GET['type']))
        @if($_GET['type'] == 'news')
            <x-manager-news-list />
        @elseif ($_GET['type'] == 'stocks')
            <x-manager-stocks-list />
        @endif
    @endif
</main>
@include('layouts.footer')