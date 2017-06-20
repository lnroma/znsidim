@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <h2>Блоги тега {{ $tag->title }}</h2>
    @if($blogs->count() > 0)
        @foreach($blogs as $_blog)
            @include('blogs.element.blog', array('_blog' => $_blog))
        @endforeach
    @else
        В этом теге нет блогов
    @endif
    {{$blogs->render()}}
@endsection
