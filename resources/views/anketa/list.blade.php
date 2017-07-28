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
    @foreach($ankets as $_ankets)
        @include('anketa.element.anketa', array('anketa' => $_ankets))
    @endforeach
    {{ $ankets->render() }}
@endsection
