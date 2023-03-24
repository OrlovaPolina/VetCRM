<div>
    <?
    // echo '<pre>' . print_r($users, 1) . '</pre>'
    ?>
    @if(isset($users))
    <div class="users-table d-flex position-absolute top-50 start-50 translate-middle">
        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col" class="fs-2">id</th>
                    <th scope="col" class="fs-2">ФИО</th>
                    <th scope="col" class="fs-2">E-mail</th>
                    <th scope="col" class="fs-2">Врач</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td class="fs-2">{{$user->id}}</td>
                <td class="fs-2">{{$user->name}}</td>
                <td class="fs-2">{{$user->email}}</td>
                @if(intval($user->role) == 2)
                <td class="fs-2 text-indigo-600" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-custom-class="custom-tooltip" title="Менеджер">
                    <i class="bi bi-emoji-sunglasses"></i>
                </td>
                @elseif(intval($user->role) == 1)
                <td class="fs-2 text-success" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-custom-class="custom-tooltip" title="Врач">
                    <i class="bi bi-star"></i>
                </td>
                @else
                <td class="fs-2" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-custom-class="custom-tooltip" title="Пользователь">
                    <i class="bi bi-check-circle"></i>
                </td>
                @endif
            </tr>          
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>