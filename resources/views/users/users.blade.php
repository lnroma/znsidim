@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            {!! Breadcrumbs::render('users') !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    Пользователи
                </div>
                <div class="panel-body">
                    <?php foreach ($users->getCollection() as $item): ?>
                    <img src="<?php echo $item->avatar ?>" height="50px" width="50px" class="img-circle">
                    <a href="/user/show/<?php echo $item->name ?>"><?php echo $item->name ?></a><br/>
                    <div class="btn-group" role="group" arial-label="Управление">
                        <a href="/message/send/{{$item->name}}" class="btn btn-info">Написать</a>
                    </div>
                    <hr/>
                    <?php endforeach; ?>
                    <?php echo $users->render() ?>
                </div>
            </div>
        </div>
    </div>
@endsection