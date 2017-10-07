<div class="panel panel-info">
    <div class="panel-heading">
        <?php if ($item->isOnline()): ?>
        <span class="glyphicon glyphicon-user " style="color:green"></span>
        <?php else: ?>
        <span class="glyphicon glyphicon-user " style="color:red"></span>
        <?php endif; ?>
        {!! UserHelper::getLinkById($item->id) !!} |
        @if($item->hello)
            {{ $item->hello }}
        @else
            Я не придумал приветсвие
        @endif
        | {{ $item->created_at }}

        <div class="btn-group pull-right" role="group" arial-label="Управление">
            @if(!Auth::guest())
                <a href="/message/send/{{$item->name}}" class="btn-sm btn-info"><span class="glyphicon glyphicon-send"></span> </a>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <img src="<?php echo $item->avatar ?>" height="50px" width="50px" class="img-circle">
        @if($item->about_me)
            {{ $item->about_me }}
        @else
            Я не придумал ещё о себе
        @endif
    </div>
</div>
