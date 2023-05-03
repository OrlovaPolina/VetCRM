<div class="animal-box container-fluid d-flex position-relative w-100 p-10">
    @if(isset($animals))
    @if(count($animals)>=0)
    @foreach ($animals as $animal)
        <div class="animal container-fluid d-flex position-relative w-90 start-50 translate-middle-x">           
            <table>
                <thead>
                    <tr>
                        <th>Кличка</th>
                    </tr>
                    <tr>
                        <th>Порода</th>
                    </tr>
                    <tr>
                        <th>Вид</th>
                    </tr>
                    <tr>
                        <th>Дата последнего посещения</th>
                    </tr>
                    <tr>
                        <th>Вес</th>
                    </tr>
                    <tr>
                        <th>Возраст</th>
                    </tr>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$animal->name}}</td>
                    </tr>
                    <tr>
                        <td>{{$animal->breed->name}}</td>
                    </tr>
                    <tr>
                        <td>{{$animal->species->name}}</td>
                    </tr>
                    <tr>
                        @php
                        if(isset($events[$animal->id])){
                            $date = new DateTimeImmutable($events[$animal->id]);
                            $date = $date->format('Y-m-d H:i');
                        }
                        else
                        $date = 'Еще не было приёма';
                        @endphp
                        <td>{{isset($events[$animal->id]) ? $date  : '-'}}</td>
                    </tr>
                    <tr>
                        <td>{{isset($visits[$animal->id])  ? $visits[$animal->id] .' кг': '-'}}</td>
                    </tr>
                    <tr>
                        <td>{{$animal->age}}</td>
                    </tr>
                    <tr>
                        <td>
                            <form action="{{route('user.download')}}" method="post">             
                                @csrf               
                                <input type="hidden" name="id" value="{{$animal->id}}">
                                <a class="download" href="" onclick="event.preventDefault();
                                    this.closest('form').submit();">Карточка животного</a>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
    @endif
    @endif
</div>