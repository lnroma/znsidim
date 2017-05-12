<div class="panel panel-info">
    <div class="panel-heading">{{ $item->created_at }} | {{ $item->name  }} |
        @if($item->hello)
            {{ $item->hello }}
        @else
            Я не придумал приветсвие
        @endif
    </div>
    <div class="panel-body">
        <img src="<?php echo $item->avatar ?>" height="50px" width="50px" class="img-circle">
        @if($item->about_me)
            {{ $item->about_me }}
        @else
            Я не придумал ещё о себе
        @endif
    </div>
    <div class="panel-footer">
        <div class="btn-group" role="group" arial-label="Управление">
            <a href="/message/send/{{$item->name}}" class="btn btn-info">Написать</a>
            <a href="/user/show/{{$item->name}}" class="btn btn-info">Просмотреть</a>
        </div>
    </div>
</div>
