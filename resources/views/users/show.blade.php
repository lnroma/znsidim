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
                    <span class="badge" >offline</span>
                @endif
                |
            <?php if($hello): ?>
                   <?php echo $hello ?>
                <?php else: ?>
            Я ещё не придумал приветствие
            <?php endif; ?> |
                <a href="/message/send/{{$name}}" class="btn-sm btn-info">Написать</a>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $avatar ?>" width="200px" height="200px" border="0" class="img-circle">
                </div>
                <div class="col-md-8">
                    <span class="label label-info">Обо мне</span>
                    <?php if ($about_me): ?>
                        <?php echo $about_me ?>
                        <?php else: ?>
                    Я пока не придумал что написать о себе
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <span class="label label-info">День рождения</span>
                    <?php if($birthday): ?>
                        <?php echo $birthday; ?>
                        <?php else: ?>
                    Неизвестно
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
@endsection