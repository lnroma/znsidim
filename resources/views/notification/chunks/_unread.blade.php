@if($notifications->count() == 0)
    У вас нет новых оповещений
@else
    @foreach($notifications->toArray() as $_notify)
        @if($_notify['type'] == \App\Notifications\UserEvents::class )
            @include('notification.chunks._viewpanel', array(
                            'notify' => $_notify
                        )
                    )
        @endif
    @endforeach
@endif