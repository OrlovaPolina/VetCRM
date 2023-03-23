<div>
    <?
    // echo '<pre>' . print_r($users, 1) . '</pre>'
    ?>
    @if(isset($users))
    <div class="w-100 d-flex">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>ФИО</th>
                    <th>E-mail</th>
                    <th>Врач</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><i class="bi bi-patch-plus-fill @if(intval($user->role) == 1) bg-green @endif"></i> </td>
            </tr>          
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>