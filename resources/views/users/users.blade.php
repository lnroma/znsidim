@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">
            Пользователи
        </div>
        <div class="panel-body">
            <?php foreach ($users->getCollection() as $item): ?>
            @include('users.view.list')
            <?php endforeach; ?>
            <?php echo $users->render() ?>
        </div>
    </div>
@endsection