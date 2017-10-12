@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('messages') !!}
    @include('layouts.snipets.error')
    <h2>Диалоги</h2>
    <?php $notfirst = false; ?>
    <?php foreach ($threads as $_thread): ?>
    <div class="panel panel-info" <?php if($notfirst): ?> style="margin-top:-35px" <?php endif ?> >
        <?php $notfirst = true;?>
        <div class="panel-heading">
            @if($_thread->withUser->isOnline())
                <span class="glyphicon glyphicon-user " style="color:green"></span>
            @else
                <span class="glyphicon glyphicon-user " style="color:red"></span>
            @endif
            <?php echo $_thread->withUser->name ?>
            <span class="pull-right">
            <div class="btn-group">
                <a href="/messages/chat/<?php echo $_thread->withUser->name ?>"
                   class="btn btn-sm btn-info">Читать</a>
            </div>
            </span>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2">
                    <img src="<?php echo $_thread->withUser->avatar ?>" width="100px" height="100px"
                         class="img-circle">
                </div>
                <div class="col-sm-8">
                    <?php if($_thread->thread->user_id == Auth::user()->id): ?>
                    <b>Я:</b>
                    <?php else: ?>
                    <b><?php echo $_thread->withUser->name ?></b>
                    <?php endif; ?>
                    <?php echo substr($_thread->thread->message, 0, 200) . '...' ?>
                </div>
                <div class="col-sm-8 info">
                    <?php if($_thread->thread->is_seen): ?>
                    Прочитано
                    <?php else: ?>
                    Не прочитано
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
@endsection