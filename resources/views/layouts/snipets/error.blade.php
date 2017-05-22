@if($message = MessageHelper::getMessages())
    @foreach($message as $_type => $_message)
        <div class="alert alert-{{$_type}}">{!! implode('<br/>', $_message) !!}</div>
    @endforeach
@endif