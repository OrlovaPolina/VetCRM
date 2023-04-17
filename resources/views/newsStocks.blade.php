@include('layouts.header')

<main>
    <h1>{{$title}}</h1>
<x-news-stocks-list :content="$content" :type="$type">

</x-news-stocks-list>

</main>
@include('layouts.footer')