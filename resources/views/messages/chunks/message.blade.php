<?php //var_dump($user, $comment);
    if($user_id != '-1') {
        $user = UserHelper::getUserById($user_id);
        $avatar = $user->avatar;
        $link = UserHelper::getLinkById($user_id);
    } else {
        $avatar = '/img/noimage.jpg';
        $link = $comment->name;
    }
?>
<div class="row">
    <div class="col-sm-1">
        <div class="comment-left thumbnail">
            <img class="img-responsive user-photo" src="{{ $avatar }}">
        </div>
    </div>

    <div class="col-sm-5">
        <div class="comment-left panel panel-default">
            <div class="panel-heading">
                <strong>{!! $link  !!}</strong> <span class="text-muted">{{ $comment->created_at }}</span>
            </div>
            <div class="panel-body">
                {!! $comment->comment !!}
            </div>
        </div>
    </div>
</div>
