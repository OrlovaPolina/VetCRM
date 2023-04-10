<div class="users-table d-grid position-relative top-50 start-50 translate-middle-x">
  <div class="input-group mb-3">
    <h2>Создание новостей и акций</h2>
  </div>
    <form enctype="multipart/form-data" class="container-fluid" action="{{route('manager.newsStocks')}}" method="post">
    @csrf
    <div class="input-group mb-3">
    <select class="form-select" name="type" aria-label="Выберите тип записи">
        <option value="0" selected>Новость</option>
        <option value="1">Акция</option>
      </select>
    </div>
    <div class="input-group mb-3 images" id="images">
      <div class="input-group">
        <input type="file" name="images[0]" class="image" aaccept="image/png, image/gif, image/jpeg, image/jpg">
        <img src="preview-image.png" id="image-0" alt="Preview">
        <i class="bi bi-x-circle-fill"></i>
      </div>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Название</span>
      <input type="text" class="form-control" name="title" placeholder="Название" aria-label="Название" aria-describedby="basic-addon1">
    </div>  
    <div class="form-floating input-group mb-3">
    <span class="input-group-text" id="floatingTextarea">Контент</span>
    <textarea class="form-control" name="content"  aria-describedby="floatingTextarea" id="floatingTextarea">
      </textarea>
    </div> 
    
    <div class="form-floating input-group mb-3">
        <span class="input-group-text" id="active_to">Активен до</span>
        <input type="datetime-local" name="active_to" id="active_to"
        aria-describedby="active_to">
    </div>
    <div class="input-group mb-3">
      <button type="submit" class="btn btn-success w-100">Создать</button>
    </div>
    </form>
</div>