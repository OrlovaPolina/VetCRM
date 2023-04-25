<?
    // echo '<pre>' . print_r($events[0]->animal, 1) . '</pre>';die();
    ?>
<div class="animal-box container-fluid d-flex position-relative w-100 p-10">    
    @if(isset($events))
    @if(count($events)>=0)
    @php
        $count = 1;
    @endphp
    @foreach ($events as $event)
    
        <div class="events d-flex position-relative w-90 start-50 translate-middle-x">
            <div class="accordion w-100" id="accordionFlush">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button w-100 collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse{{$event->id}}"
                        aria-expanded="false"
                        aria-controls="flush-collapse{{$event->id}}">
                        <div class="d-flex w-100">
                            <div>№ {{$count}}</div>
                            <div>{{$event->title}}</div>
                            <div>{{$event->animal->name}} / {{$event->animal->species->name}}</div>
                            <div>{{$event->start}}</div>
                        </div>
                      </button>
                    </h2>
                    <div id="flush-collapse{{$event->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                      <div class="accordion-body">
                        <div class="d-grid">
                            <div class="d-flex">
                                <div class="name">Температура: </div>
                                <div class="value">
                                    {{$visits->where('event_id',$event->id)->first()->temp}} &#xb0;С
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="name">Вес: </div>
                                <div class="value">
                                    {{$visits->where('event_id',$event->id)->first()->weight}} кг
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="name">Жалобы: </div>
                                <div class="value">
                                    {{$visits->where('event_id',$event->id)->first()->complaints}}
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="name">Осмотр: </div>
                                <div class="value">
                                    {{$visits->where('event_id',$event->id)->first()->inspection}}
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="name">Лечение: </div>
                                <div class="value">
                                    {{$visits->where('event_id',$event->id)->first()->therapy}}
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
        @php
             $count++;
        @endphp
    @endforeach
    @endif
    @endif
</div>