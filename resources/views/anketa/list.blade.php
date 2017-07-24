@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('dating') !!}
    @include('layouts.snipets.error')
    <h2>Знакомства</h2>
    <span>
    <div class="panel panel-default">
        <div class="panel-heading">
          <button type="button" class="btn btn-default btn-xs spoiler-trigger"
                  data-toggle="collapse">Фильтры</button>
        </div>
        <div class="panel-collapse collapse out">
          <div class="panel-body">
                @include('anketa.element.filters')
          </div>
        </div>
    </div>
    </span>
    <br/>
    &nbsp; <br>
    @foreach($ankets as $_ankets)
        @include('anketa.element.anketa', array('anketa' => $_ankets))
    @endforeach
    {{ $ankets->render() }}
@endsection
