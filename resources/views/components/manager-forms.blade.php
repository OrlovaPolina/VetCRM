@if(isset($users))
    <div class="users-table d-flex position-absolute top-50 start-50 translate-middle-x">
        <form action="" method="post">
            @csrf
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" class="fs-2">id</th>
                        <th scope="col" class="fs-2">ФИО</th>
                        <th scope="col" class="fs-2">E-mail</th>
                        <th scope="col" class="fs-2">Роль</th>
                        <th scope="col" class="fs-2">Врач</th>
                        <th scope="col" class="fs-2">ЧС</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr 
                @if(intval($user->blacklist) == 1) class="text-danger" 
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip" title="Пользователь в чёрном списке"
                @endif>
                    <input type="hidden" name="users[{{$user->id}}][id]" value="{{$user->id}}">
                    <td class="fs-2">{{$user->id}}</td>
                    <td class="fs-2">{{$user->name}}</td>
                    <td class="fs-2">{{$user->email}}</td>
                    @if(intval($user->role) == 2)
                    <td class="fs-2 role text-indigo-600" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip" title="Менеджер">
                        <i class="bi bi-emoji-sunglasses"></i>
                    </td>
                    @elseif(intval($user->role) == 1)
                    <td class="fs-2 role text-success" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip" title="Врач">
                        <i class="bi bi-star"></i>
                    </td>
                    @else
                    <td class="fs-2 role" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip" title="Пользователь">
                        <i class="bi bi-check-circle"></i>
                    </td>
                    @endif
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="users[{{$user->id}}][role]" type="checkbox" 
                            @if(intval($user->role) == 1) checked 
                            @elseif(intval($user->role) == 2) disabled @endif
                            role="switch" >
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="users[{{$user->id}}][blacklist]" type="checkbox" 
                                @if(intval($user->blacklist) == 1) checked 
                                @elseif(intval($user->role) == 2) disabled @endif
                                role="switch" >
                        </div>
                    </td>
                </tr>          
                @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
    @endif