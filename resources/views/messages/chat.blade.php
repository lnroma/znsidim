@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('messages_show', $user) !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php if ($user->isOnline()): ?>
            <span class="glyphicon glyphicon-user " style="color:green"></span>
            <?php else: ?>
            <span class="glyphicon glyphicon-user " style="color:red"></span>
            <?php endif; ?>
            Диалог {!! UserHelper::getLinkById($user->id) !!}
            <a href="/message/settings" class="pull-right btn-sm btn-primary"><span
                        class="glyphicon glyphicon-cog"></span> </a>
        </div>
    </div>
    @if($inputUp)
        @include('messages.chunks.user.form', [
            'action' => '/message/send',
            'hiddens' => [
                'login' => $user->name
            ],
            'name_field' => 'message',
            'form_container' => true,
            'id_editor' => 'message',
        ])
    @endif
    <?php /** @var Nahid\Talk\Messages\Message $_message */ ?>
    <?php foreach ($messages as $_message): ?>
    @include('messages.chunks.user.message')
    <?php endforeach; ?>
    @include('messages.chunks.user.pagination')
    @if(!$inputUp)
        @include('messages.chunks.user.form', [
            'action' => '/message/send',
            'hiddens' => [
                'login' => $user->name
            ],
            'name_field' => 'message',
            'form_container' => true,
            'id_editor' => 'message',
        ])
    @endif
@endsection