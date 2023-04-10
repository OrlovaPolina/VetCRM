<div class="users-table d-flex position-relative top-50 start-50 translate-middle-x">
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" class="fs-2">id</th>
                <th scope="col" class="fs-2">Title</th>
                <th scope="col" class="fs-2">Статус</th>
                <th scope="col" class="fs-2">Изменить</th>
                <th scope="col" class="fs-2">Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>
                        {{$stock->id}}
                    </td>
                    <td>
                        {{$stock->title}}
                    </td>
                    <td>
                        @if($stock->deleted_at != null)
                        Не активен
                        @else
                        Активен                       
                        @endif
                        </td>
                    <td>
                        <a href="{{route('manager.editNewsStocksPage',['type'=>'stocks','id'=>$stock->id])}}">Изменить</a>
                    </td>
                    <td>                       
                        @if($stock->deleted_at != null)
                        <form action="{{route('manager.restoreNewsStocks',['type'=>'stocks','id'=>$stock->id])}}" method="post">@csrf
                            <a href="{{route('manager.restoreNewsStocks',['type'=>'stocks','id'=>$stock->id])}}" onclick="event.preventDefault();
                                this.closest('form').submit();">Восстановить</a>
                        </form>
                        
                        @else
                        <form action="{{route('manager.deleteNewsStocks',['type'=>'stocks','id'=>$stock->id])}}" method="post">@csrf
                            <a href="{{route('manager.deleteNewsStocks',['type'=>'stocks','id'=>$stock->id])}}" onclick="event.preventDefault();
                                this.closest('form').submit();">Отключить</a>  
                        </form>
                                     
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $stocks->links() }}