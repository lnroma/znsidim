@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('dating') !!}
    @include('layouts.snipets.error')
    <h2>Знакомства</h2>
    @include('anketa.element.filters')
    <br/>&nbsp;<br/>
    <?php if($ankets->count() == 0): ?>
    <div class="alert alert-danger">По вашему запросу анкеты не найдены</div>
    <?php endif; ?>

    <?php $userArray = $ankets->getCollection()->toArray() ?>
    <?php $userArray = array_chunk($userArray, 3) ?>
    <?php foreach ($userArray as $user): ?>
    <div class="row">
        <?php foreach($user as $item): ?>
            <?/** @var $item \App\User */ ?>
        <?php $item = UserHelper::getUserById($item['user_id'])->ankets ?>
        <div class="col-md-4">
            @include('anketa.element.anketa', ['anketa' => $item])
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    {{ $ankets->render() }}
@endsection
