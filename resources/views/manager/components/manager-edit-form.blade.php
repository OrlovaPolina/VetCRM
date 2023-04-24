<div class="users-table d-grid position-relative top-50 start-50 translate-middle-x">
  <div class="input-group mb-3">
    <h2>Изменение публикации</h2>
  </div>
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
    @if(isset($content->images_urls) && count($content->images_urls) >= 1)
      @foreach($content->images_urls as $key=>$img)
            <div class="input-group">
                <input value="{{asset($img)}}" type="file" name="images[{{$key}}]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
                <img src="{{asset($img)}}" id="image-{{$key}}" alt="">
                <i class="bi bi-x-circle-fill"></i>
            </div>
      @endforeach
   @endif
        <div class="input-group">
          @if(isset($content->images_urls) && count($content->images_urls) >= 1)
            <input type="file" name="images[{{count($content->images_urls)}}]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
            <img src="preview-image.png" id="image-{{count($content->images_urls)}}" alt="Preview">
          @elseif(isset($content->images_urls) && count($content->images_urls) < 1 || !isset($content->images_urls))
          <input type="file" name="images[0]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
          <img src="preview-image.png" id="image-0" alt="Preview">
          @endif
            
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
    <div class="form-floating input-group mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" 
          name="deleted_at"
          type="checkbox"
          role="switch"
          id="deleted_at" 
          @if(!is_null($content->deleted_at))
          checked
          @endif
          >
          <label class="form-check-label" for="deleted_at">
          @if(!is_null($content->deleted_at))
          Отключен
          @else
          Включен
          @endif

          </label>
        </div>
    </div>
    
    <div class="input-group mb-3">
      <button type="submit" class="btn btn-success w-100">Сохранить</button>
    </div>
    </form>
</div>