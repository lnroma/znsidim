<?php //var_dump($user, $comment);
if ($user_id != '-1') {
    $user = UserHelper::getUserById($user_id);
    $avatar = $user->avatar;
    $link = UserHelper::getLinkById($user_id);
} else {
    $avatar = '/img/noimage.jpg';
    $link = $comment->name;
    $user = null;
}
?>
<div class="panel panel-default" >
    <div class="panel-heading">
        <?php if($user): ?>
        <?php if ($user->isOnline()): ?>
        <span class="glyphicon glyphicon-user " style="color:green"></span>
        <?php else: ?>
        <span class="glyphicon glyphicon-user " style="color:red"></span>
        <?php endif; ?>
        <?php endif; ?>
        <strong>{!! $link  !!}</strong> <span class="text-muted">{{ $comment->created_at }}</span>
        @can('superadmin')
            <a href="/comment/delete/{{ $comment->id }}" class="btn-sm btn-default"><span
                        class="glyphicon glyphicon-erase"></span></a>
        @endcan
    </div>
    <div class="panel-body">
        {!! strip_tags($comment->comment, '<br><a><img><blockquote><strike><b><p><i><code><p><h2><h3><h1><h4><ul><li><ol><pre>') !!}
    </div>
    <div class="panel-footer">
        {!! $aditional !!}
    </div>
</div>

