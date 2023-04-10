<div class="users-table d-grid position-relative top-50 start-50 translate-middle-x">
  <div class="input-group mb-3">
    <h2>Изменение публикации</h2>
  </div>

  <?
//   echo '<pre>' . print_r($content, 1) . '</pre>';die();
  ?>
    <form enctype="multipart/form-data" class="container-fluid"
    action="{{route('manager.editNewsStocks',['type'=>$type,'id'=>$content->id])}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$content->id}}">
    <div class="input-group mb-3">
        <input type="hidden" name="type" value="@if($type == 'news') 0 @else 1 @endif">
        <h2>
        @if($type == 'news')
        Новость
        @else
        Акция
        @endif
        </h2>
    </div>
    <div class="input-group mb-3 images" id="images">
   @foreach($content->images_urls as $key=>$img)
        <div class="input-group">
            <input value="{{asset($img)}}" type="file" name="images[{{$key}}]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
            <img src="{{asset($img)}}" id="image-{{$key}}" alt="">
            <i class="bi bi-x-circle-fill"></i>
        </div>
   @endforeach
        <div class="input-group">
            <input type="file" name="images[{{count($content->images_urls)}}]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
            <img src="preview-image.png" id="image-{{count($content->images_urls)}}" alt="Preview">
            <i class="bi bi-x-circle-fill"></i>
        </div>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Название</span>
      <input type="text" class="form-control"
       name="title"
       placeholder="Название"
       aria-label="Название"
       aria-describedby="basic-addon1"
       value="{{$content->title}}">
    </div>  
    <div class="form-floating input-group mb-3">
    <span class="input-group-text" id="floatingTextarea">Контент</span>
      <textarea class="form-control" name="content"  aria-describedby="floatingTextarea" id="floatingTextarea">
        {{$content->content}}
      </textarea>
    </div> 
    <div class="form-floating input-group mb-3">
        <span class="input-group-text" id="active_to">Активен до</span>
        <input type="datetime-local" name="active_to" id="active_to" 
       aria-describedby="active_to" value="{{$content->active_to}}">
    </div>
    
    <div class="input-group mb-3">
      <button type="submit" class="btn btn-success w-100">Сохранить</button>
    </div>
    </form>
</div>