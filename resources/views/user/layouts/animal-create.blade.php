@include('layouts.header')
<main class="position-relative animal-create-box">
    <div class="animal-table w-50 top-10 d-grid position-absolute start-50 translate-middle-x">
    <form action="{{route('user.animalsCreate')}}" method="post">
    @csrf
    <div class="input-group mb-3">
        <span class="input-group-text" id="name">Кличка</span>
        <input type="text" class="form-control"
         name="name"
         placeholder="Кличка"
         aria-label="Кличка"
         aria-describedby="name">
    </div>  
    <div class="input-group mb-3">
        <span class="input-group-text" id="breed">Порода</span>
        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
        <datalist id="datalistOptions">
            {{-- <option value="San Francisco">
            <option value="New York">
            <option value="Seattle">
            <option value="Los Angeles">
            <option value="Chicago"> --}}
            @foreach ($breed as $b)
                <option value="{{$b->id}}">{{$b->name}}</option>
            @endforeach   
          </datalist>
          <input type="hidden" name = "breed">
        {{-- <select class="form-select form-select-lg mb-3"
        aria-label=".form-select-lg example"        
        placeholder="Порода"
        aria-label="Порода"
        aria-describedby="breed">
            @foreach ($breed as $b)
                <option value="{{$b->id}}" @if($b->id == 1) selected @endif>{{$b->name}}</option>
            @endforeach           
        </select> --}}
    </div>  
    <div class="input-group mb-3">
        <span class="input-group-text" id="species">Вид</span>
        <select class="form-select form-select-lg mb-3"
        aria-label=".form-select-lg example"
        name="species"
        placeholder="Вид"
        aria-label="Вид"
        aria-describedby="species">
            @foreach ($species as $s)
                <option value="{{$s->id}}" @if($s->id == 1) selected @endif>{{$s->name}}</option>
            @endforeach           
        </select>
    </div>  
    <div class="input-group mb-3">
        <span class="input-group-text" id="age">Возраст</span>
        <input type="text" class="form-control"
         name="age"
         placeholder="Возраст"
         aria-label="Возраст"
         aria-describedby="age">
    </div>  
    <div class="input-group mb-3">
        <span class="input-group-text" id="age">
            Есть ли паспорт
        </span>
        <div class="form-floating input-group mb-3 form-control" aria-describedby="passport">
            <div class="form-check form-switch">
                <input class="form-check-input" 
                name="passport"
                type="checkbox"
                role="switch"
                id="passport">          
            </div>
        </div>
    </div> 
    <div class="input-group mb-3">
        <button class="start-50 position-relative translate-middle-x" type="submit">Добавить</button>
    </div>
    </form>
    </div>
</main>
@vite([       
    'resources/js/user.js',  
])
@include('layouts.footer')