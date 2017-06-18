@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <h2>Результаты поиска по блогам {{$total}}</h2>
    @if($total > 0)
        @foreach($blogs as $_blog)
            @include('blogs.element.blog', array('_blog' => $_blog))
        @endforeach
        {{$blogs->render()}}
    @else
        Ничего не найденно
    @endif
@endsection
