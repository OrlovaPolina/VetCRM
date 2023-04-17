<div class="container">
    @if(!empty($content))
    @php($count = 0)
        @foreach($content as $item)
            @if($count % 3 == 0 && $count != 0)            
            </div>
            <div class="row">
            @elseif($count % 3 == 0 && $count == 0)
            <div class="row">
            @endif
                <a href="{{route('NSdetail',['type'=>$type,'id'=>$item->id])}}" class="col">
                    <div class="row">
                        <img src="{{$item->images_urls[0]}}" class="img-fluid" alt="{{$item->title}}">
                    </div>
                    <div class="row">
                        <p>
                            {{$item->title}}
                        </p>
                    </div>
                    <div class="row">
                        <p>
                            {{mb_substr($item->content,0,10)}}...
                        </p>
                    </div>
                </a>
            @if($count == count($content))
                </div>
            @endif
            @php($count++)
        @endforeach
    @endif
</div>
{{ $content->links() }}