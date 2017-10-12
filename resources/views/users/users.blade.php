@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users') !!}
    @include('layouts.snipets.error')
    <?php $usersRender = $users->getCollection()->toArray(); ?>
    <?php $usersRender = array_chunk($usersRender, 3) ?>
    <?php foreach ($usersRender as $user): ?>
    <div class="row">
        <?php foreach ($user as $item): ?>
        <?php $item = UserHelper::getUserById($item['id']) ?>
        <div class="col-md-4">
            @include('users.view.list')
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <?php echo $users->render() ?>
@endsection