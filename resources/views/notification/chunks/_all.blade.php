@foreach($all->paginate(10) as $_notify)
    @if($_notify['type'] == \App\Notifications\UserEvents::class )
        @include('notification.chunks._viewpanel',
                        array(
                                'notify' => $_notify->toArray()
                             )
                 )
    @endif
@endforeach
{{ $all->paginate(10)->links() }}
