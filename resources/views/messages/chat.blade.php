@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('messages_show', $user) !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">
            Диалог <?php echo $user->name ?>
        </div>
        <div class="panel-body">
            <?php /** @var Nahid\Talk\Messages\Message $_message */ ?>
            <?php foreach ($messages as $_message): ?>
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
            <?php endforeach; ?>
            <form class="form-horizontal" action="/message/send" method="post">
                <input type="hidden" name="login" id="login" value="<?php echo $user->name ?>"
                       class="form-control"/>
                <div class="form-group">
                    <label for="message" class="control-label">Сообщение</label>
                    <textarea name="message" id="message" class="form-control"></textarea>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Отправить</button>
                </div>
            </form>
        </div>
    </div>
@endsection