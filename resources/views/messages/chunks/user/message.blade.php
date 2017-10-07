<?php $notRead = $_message->user_id == Auth::user()->id && !$_message->is_seen ?>
<div class="<?php if($notRead): ?>panel-warning<?php else: ?>panel-info<?php endif; ?>">
    <div class="panel-heading">
        <?php if($_message->user_id == Auth::user()->id): ?>
        <b>Я</b>
        <?php else: ?>
        <b><?php echo $user->name ?></b>
        <?php $_message->is_seen = 1; $_message->save(); ?>
        <?php endif; ?>
        |
        <?php echo $_message->created_at ?>
        <?php if($notRead): ?>
        | Не прочитано
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <?php echo $_message->message ?>
    </div>
</div>