@include('layouts.header')
<main>
  <div class="d-flex flex-column">
    @if (isset($stocks) && count($stocks) > 0)
    <div id="carouselExample" class="carousel slide" style="width: 37vw;height: 477px;left: 50%;transform: translate(-50%);margin-top: 66px;">
        <div class="carousel-inner" style="height: 100%;">
          @foreach ($stocks as $stock)
          @if(!empty($stock->images_urls))
            <a href="{{route('NSdetail',['type'=>'stocks','id'=>$stock->id])}}">
              <div class="carousel-item active" style="height: 100%;">
                <div style="
                background:url({{$stock->images_urls[0]}});
                background-size: contain;
                display: block;
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;"
                class="img-fluid" alt="{{$stock->title}}"></div>
              </div>
            </a>
            @endif
          @endforeach    
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    @endif
      <h2>Новости</h2>
      <x-news-stocks-list :content="$content" :type="$type">

      </x-news-stocks-list>
    </div>  
</main>
@include('layouts.footer')