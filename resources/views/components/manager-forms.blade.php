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
                <td class="fs-2 @if(intval($user->role) == 1) text-success @endif"><i class="bi bi-patch-plus-fill"></i> </td>
            </tr>          
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>