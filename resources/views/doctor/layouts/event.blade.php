@include('layouts.header')
<main>
    <h1>Заполните данные о приёме</h1>
<form method="post">
    <input type="hidden" name="event_id" value="{{$event_id}}">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col">        
                @if(isset($visits))
                <input type="hidden" name="visits[id]" value="{{$visits->id}}">
                @endif
                <input type="hidden" name="visits[animal_id]" value="{{$animal->animal_id}}">
                <input type="hidden" name="visits[event_id]" value="{{$event_id}}">
                <input type="hidden" name="visits[doctor_id]" value="{{Auth::user()->id}}">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="weight">Вес</span>
                    <input required type="text" class="form-control"
                    name="visits[weight]"
                    placeholder="Вес"
                    aria-label="Вес"
                    aria-describedby="weight"
                    @if(isset($visits)) value="{{$visits->weight}}" @endif
                    >
                    <span class="input-group-text" id="temp">Температура</span>
                    <input required type="text" class="form-control"
                    name="visits[temp]"
                    placeholder="Температура"
                    aria-label="Температура"
                    aria-describedby="temp"
                    @if(isset($visits)) value="{{$visits->temp}}" @endif
                    >
                </div>  
                <div class="input-group mb-3">
                    <span class="input-group-text" id="complaints">Жалобы</span>
                    <textarea required type="text" class="form-control"
                    name="visits[complaints]"
                    aria-label="Жалобы"
                    aria-describedby="complaints">@if(isset($visits)) {{$visits->complaints}} @endif</textarea>
                </div>  
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inspection">Осмотр</span>
                    <textarea required type="text" class="form-control"
                    name="visits[inspection]"
                    aria-label="Осмотр"
                    aria-describedby="inspection">@if(isset($visits)) {{$visits->inspection}} @endif</textarea>
                </div>  
                <div class="input-group mb-3">
                    <span class="input-group-text" id="therapy">Лечение</span>
                    <textarea required type="text" class="form-control"
                    name="visits[therapy]"
                    aria-label="Лечение"
                    aria-describedby="therapy">@if(isset($visits)) {{$visits->therapy}} @endif</textarea>
                </div> 
            </div>
            <div class="col">
                {{-- Вакцинация --}}
                
                <p> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="vaccinations[check]" type="checkbox" role="switch" id="vaccinations" 
                        data-bs-toggle="collapse"
                        data-bs-target="#vaccinationsCol" 
                        aria-expanded="false" 
                        aria-controls="vaccinationsCol">
                        <label class="form-check-label" for="vaccinations">Вакцинация</label>
                    </div>
                </p> 
                <div class="collapse" id="vaccinationsCol">
                    <div class="card card-body">                       
                        <div class="input-group mb-3">
                            @if(isset($vaccinations))
                                <input type="hidden" name="vaccinations[id]" value="{{$vaccinations->id}}">
                            @endif
                            <input type="hidden" name="vaccinations[animal_id]" value="{{$animal->animal_id}}">
                            <span class="input-group-text" id="vaccine">Вакцина:</span>
                            <input type="text" class="form-control"
                            name="vaccinations[vaccine]"
                            aria-label="Вакцина"
                            aria-describedby="vaccine"
                            @if(isset($vaccinations)) 
                            <?
                            $now = Illuminate\Support\Carbon::now();
                            $date = new Illuminate\Support\Carbon($vaccinations->sell_by);
                            $date_diff = $now->diffInHours($date,false);
                            ?>
                                @if($date_diff > 0)
                                value="{{$vaccinations->vaccine}}" 
                                @endif
                            @endif
                            >
                            <span class="input-group-text" id="sell_by">Действует до:</span>
                            <input type="datetime-local" class="form-control"
                            name="vaccinations[sell_by]"
                            aria-label="Действует до"
                            aria-describedby="sell_by"
                            @if(isset($vaccinations)) 
                                @if($date_diff > 0)
                                <? $date->format('Y-m-d\TH:i:sP');?>
                                value="<?=$date?>" 
                                @endif
                            @endif
                            >
                        </div>
                    </div>
                </div>
                {{-- Запись на повторный приём --}}
                <p> 
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="reAdmission[check]" type="checkbox" role="switch" id="reAdmission" 
                        data-bs-toggle="collapse"
                        data-bs-target="#reAdmissionCol" 
                        aria-expanded="false" 
                        aria-controls="reAdmissionCol">
                        <label class="form-check-label" for="reAdmission">Записать на повторный приём</label>
                    </div>
                </p> 
                <div class="collapse" id="reAdmissionCol">
                    <div class="card card-body">                       
                        <div class="input-group mb-3 d-flex justify-content-evenly">
                            <span>Животное</span>
                            <span id="reAd_animal_name">{{$animal->animal->name}}</span>
                            <input type="hidden" name="reAdmission[animal_id]" value="{{$animal->animal_id}}">
                            <input type="hidden" name="reAdmission[user_id]" value="{{$animal->user_id}}">
                        </div>
                        @csrf
                        <div class="input-group mb-3 d-flex">
                            <span class="input-group-text" id="doctors">Выберите врача</span>
                            <select id="doctors-select" class="form-select form-select-lg mb-3"
                            aria-label=".form-select-lg example"
                            name="reAdmission[doctors]"
                            placeholder="Выберите врача"
                            aria-label="Выберите врача"
                            aria-describedby="doctors">
                            <option value="" disabled selected hidden >Выберите врача</option>
                                @foreach ($doctors as $d)
                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach           
                            </select>
                        </div>
                        <div class="input-group mb-3 d-flex">
                            <span class="input-group-text" id="doctors-date">Выберите свободное время</span>
                            <select  class="form-select form-select-lg mb-3"
                            aria-label=".form-select-lg example"
                            name="reAdmission[doctors_date]"
                            placeholder="Выберите врача"
                            aria-label="Выберите врача"
                            aria-describedby="doctors-date">
                                         
                            </select>
                            <select class="form-select form-select-lg mb-3"
                            aria-label=".form-select-lg example"
                            name="reAdmission[doctors_time]"
                            placeholder="Выберите врача"
                            aria-label="Выберите врача"
                            aria-describedby="doctors-time">
                                          
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </div>
    
</form>
</main>

<script src="/js/fullCalendar/index.global.js"></script>
<script src="/js/fullcalendar-6.1.6/fullcalendar-6.1.6/packages/core/locales-all.global.min.js"></script>
@vite([       
    'resources/js/doctor.js',  
])
@include('layouts.footer')