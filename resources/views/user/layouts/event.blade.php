@include('layouts.header')
@if (isset($error) || isset($_GET['error']))
<div class="alert alert-warning position-absolute" role="alert">
    Не получилось записаться. Обратитесть в клинику по телефону. <br>
    Или обновите страницу и попробуйте ещё раз.
</div>
@endif
@if (isset($success) || isset($_GET['success']))
<div class="alert alert-success position-absolute" role="alert">
    Вы успешно записаны на приём!
</div>
@endif
<main class="position-relative animal-create-box">
    <h1 class="text-center">Запись на приём</h1>
    @auth
    <div class="event-table top-10 d-grid position-absolute start-50 translate-middle-x">
        <form action="" method="post">
            @csrf
            <div class="input-group mb-3">
                <span class="input-group-text" id="animals">Выберите животное</span>
                <select class="form-select form-select-lg mb-3"
                aria-label=".form-select-lg example"
                name="animals"
                placeholder="Выберите животное"
                aria-label="Выберите животное"
                aria-describedby="animals">
                    @foreach ($animals as $a)
                        <option value="{{$a->id}}" @if($a->id == 1) selected @endif>{{$a->name}}</option>
                    @endforeach           
                </select>
            </div>  
            <div class="input-group mb-3">
                <span class="input-group-text" id="doctors">Выберите врача</span>
                <select id="doctors-select" class="form-select form-select-lg mb-3"
                aria-label=".form-select-lg example"
                name="doctors"
                placeholder="Выберите врача"
                aria-label="Выберите врача"
                aria-describedby="doctors">
                <option value="" disabled selected hidden >Выберите врача</option>
                    @foreach ($doctors as $d)
                        <option value="{{$d->id}}">{{$d->name}}</option>
                    @endforeach           
                </select>
            </div> 
            <div class="input-group mb-3 doctors-time-select">
                <span class="input-group-text" id="doctors-date">Выберите свободное время</span>
                <select class="form-select form-select-lg mb-3"
                aria-label=".form-select-lg example"
                name="doctors_date"
                placeholder="Выберите врача"
                aria-label="Выберите врача"
                aria-describedby="doctors-date">
                             
                </select>
                <select class="form-select form-select-lg mb-3"
                aria-label=".form-select-lg example"
                name="doctors_time"
                placeholder="Выберите врача"
                aria-label="Выберите врача"
                aria-describedby="doctors-time">
                              
                </select>
            </div>
            <div class="input-group mb-3">
                <button type="submit">Записаться</button>
            </div>
        </form>
    </div>
    @endauth
</main>
@vite([       
    'resources/js/user.js',  
])
@include('layouts.footer')