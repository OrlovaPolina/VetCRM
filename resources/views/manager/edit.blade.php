@include('layouts.head')
@include('layouts.navigation')
<header class="bg-white dark:bg-gray-800 shadow mb-100">
    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
    @include('layouts.manager-nav')
    </div>
    @if(isset($_GET['success']))
    <div class="alert alert-info position-absolute" role="alert">
        Изменения сохранены!
    </div>
    @elseif(isset($_GET['error']))
    <div class="alert alert-warning position-absolute" role="alert">
        Произошла ошибка, обратитесь к разработчикам!
    </div>
    @endif
</header>
<main>
    <x-manager-edit-form :content="$content" :type="$type">

    </x-manager-edit-form>

</main>
@include('layouts.footer')