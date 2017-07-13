@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users_show', $id, $name) !!}
    @include('layouts.snipets.error')
    <div class="panel panel-info">
        <div class="panel-heading">
            <?php echo $name; ?> |
            @if(UserHelper::getUserById($id)->isOnline())
                <span class="badge" style="background:green">online</span>
            @else
                <span class="badge">offline</span>
            @endif
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $avatar ?>" width="200px" height="200px" border="0" class="img-circle">
                </div>
                <div class="col-md-8">
                    <table class="table table-responsive">
                        <tbody>
                        <tr>
                            <td>Приветствие:</td>
                            <td>
                                <?php if($hello): ?>
                   <?php echo $hello ?>
                <?php else: ?>
                                Я ещё не придумал приветствие
                                <?php endif; ?>
                            </td>
                        </tr>
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
                            <td><a href="/photos/{{$name}}" class="btn btn-nav">Фотоальбом</a></td>
                            <td>Просмотреть фотоальбом пользователя</td>
                        </tr>
                        @if(!Auth::guest())
                            <tr>
                                <td><a href="/message/send/{{$name}}" class="btn btn-nav">Написать</a></td>
                                <td>Написать пользователю сообщение</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection