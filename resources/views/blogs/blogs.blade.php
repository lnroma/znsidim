@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <h2>Блоги</h2>
    @if($blogs->count() > 0)
        @foreach($blogs as $_blog)
            @include('blogs.element.blog', array('_blog' => $_blog))
        @endforeach
    @else
        В вашем блоге пока нет записей
    @endif
    {{$blogs->render()}}
@endsection
