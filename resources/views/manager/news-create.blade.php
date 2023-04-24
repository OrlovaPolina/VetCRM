@include('layouts.head')
@include('layouts.navigation')
<div class="user-sub">
    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
    @include('layouts.manager-nav')
    </div>
</div>
<main>
    <x-manager-news-form>

    </x-manager-news-form>

    <img src="{{asset('storage/uploads/news/1680230622-vetpng.png')}}" alt="">
</main>
@include('layouts.footer')