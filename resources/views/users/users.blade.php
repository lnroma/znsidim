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
                        @include('users.view.list')
                    <?php endforeach; ?>
                    <?php echo $users->render() ?>
                </div>
            </div>
        </div>
    </div>
@endsection