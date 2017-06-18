@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('users') !!}
    @include('layouts.snipets.error')
    <h2>Результаты поиска по Пользователям {{$total}}</h2>
    <?php foreach ($users as $item): ?>
        @include('users.view.list')
        {{$users->render()}}
    <?php endforeach; ?>
@endsection