@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('mypage') !!}
    @include('layouts.snipets.error')
    <h2>Знакомства</h2>
    <span>
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#filters">Фильтры</button>
    </span>
    <br/>
    &nbsp; <br>
    @foreach($ankets as $_ankets)
        @include('anketa.element.anketa', array('anketa' => $_ankets))
    @endforeach
    {{ $ankets->render() }}
    @include('anketa.element.filters')
@endsection
