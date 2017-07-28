@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('dating') !!}
    @include('layouts.snipets.error')
    <h2>Знакомства</h2>
    <span>
        @include('anketa.element.filters')
    </span>
    <br/>
    &nbsp; <br>
    @foreach($ankets as $_ankets)
        @include('anketa.element.anketa', array('anketa' => $_ankets))
    @endforeach
    {{ $ankets->render() }}
@endsection
