@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users_show', $id, $name) !!}
    @include('layouts.snipets.error')
    <div class="panel panel-info">
        <div class="panel-heading">
            <?php if (UserHelper::getUserById($id)->isOnline()): ?>
            <span class="glyphicon glyphicon-user " style="color:green"></span>
            <?php else: ?>
            <span class="glyphicon glyphicon-user " style="color:red"></span>
            <?php endif; ?>
            <?php echo $name; ?>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $avatar ?>" width="200px" height="200px" border="0" class="img-circle">
                    <div class="bg-success">
                        <?php if($hello): ?>
                            <?php echo $hello ?>
                        <?php else: ?>
                        Я ещё не придумал приветствие
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-responsive">
                        <tbody>
                        <tr>
                            <td>Обо мне:</td>
                            <td>
                                <?php if ($about_me): ?>
                                    <?php echo $about_me ?>
                                <?php else: ?>
                                Я пока не придумал что написать о себе
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>День рождения:</td>
                            <td>
                                <?php if($birthday): ?>
                                <?php echo $birthday; ?>
                            <?php else: ?>
                                Неизвестно
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Последния активность:</td>
                            <td>
                                <?php if($userActivity = UserHelper::getUserById($id)->getLastActivite()): ?>
                                    <?php echo date('Y-m-d h:i', $userActivity) ?>
                                <?php else: ?>
                                Не известно
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="/photos/{{$name}}" class="btn btn-nav">Фотоальбом</a></td>
                            <td>Просмотреть фотоальбом пользователя</td>
                        </tr>
                        @if(!Auth::guest())
                            <tr>
                                <td><a href="/message/send/{{$name}}" class="btn btn-nav">Написать</a></td>
                                <td>Написать пользователю сообщение</td>
                            </tr>
                        @endif
                        <?php
                        $ankets = UserHelper::getUserById($id)->ankets;
                        $tables = UserHelper::getUserById($id)->tables;
                        ?>
                        @if($ankets && $ankets->is_enable)
                            <tr>
                                <td colspan="2"><b>Для знакомства</b></td>
                            </tr>
                            <tr>
                                <td>Пол:</td>
                                <td>{{ $ankets->getSexValue() }}</td>
                            </tr>
                            <tr>
                                <td>Цель:</td>
                                <td>{{ $ankets->getPurposeValue() }}</td>
                            </tr>
                            <tr>
                                <td>Текст объявления</td>
                                <td>{{ $ankets->text }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            Стена пользователя:
            <hr/>
            @foreach($tables as $_table)
                @include('messages.chunks.message', array(
                    'comment' => $_table,
                    'user_id' => $_table->user_id,
                    'aditional' => '',
                ))
            @endforeach
            <hr/>
            Комментарий:
            @include('messages.chunks.user.form', [
                    'action' => '/tables/saveComment',
                    'hiddens' => [
                        'user_id' => $id,
                    ],
                    'name_field' => 'comment',
                    'form_container' => true,
                    'id_editor' => 'message',
                ])
        </div>
    </div>
@endsection
