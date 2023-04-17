<div class="users-table d-grid position-relative top-50 start-50 translate-middle-x">
<h1 class="text-center">{{$detail->title}}</h1>
@if(!empty($detail->images_urls))
    @if(count($detail->images_urls) < 2)
    <img src="{{asset($detail->images_urls[0])}}" class="unicImg img-fluid">
    @else
<div id="carouselIndicators" class="carousel slide">
  <div class="carousel-indicators">
  @foreach($detail->images_urls as $key=>$img)
    <button type="button" data-bs-target="#carouselIndicators"
    data-bs-slide-to="{{$key}}"
    @if($key == 0) class="active" @endif
    aria-current="true"
    aria-label="Slide {{$key}}"></button> 
    @endforeach
  </div>
  <div class="carousel-inner h-100">
    @foreach($detail->images_urls as $key=>$img)
    <div class="carousel-item h-100 @if($key == 0) active @endif">
      <img src="{{asset($img)}}" class="d-block w-100 h-100">
    </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Пред.</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">След.</span>
  </button>
</div>
    @endif
@endif
@if(!empty($detail->content))
<div class="text-left">
    {{$detail->content}}
</div>
@endif
<div class="text-right">
    <p>Дата публикации: <span>{{date_format($detail->created_at,'m.d.Y')}}</span> </p>
</div>
</div>