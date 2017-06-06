@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users') !!}
    @include('layouts.snipets.error')
    <?php foreach ($users->getCollection() as $item): ?>
    @include('users.view.list')
    <?php endforeach; ?>
    <?php echo $users->render() ?>
@endsection