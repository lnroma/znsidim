@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Блоги тэга {{ $tag->name }}</div>
        <div class="panel-body">
            @if($blogs->count() > 0)
                @foreach($blogs as $_blog)
                    @include('blogs.element.blog', array('_blog' => $_blog))
                @endforeach
            @else
                В этом теге нет блогов
            @endif
            {{$blogs->render()}}
        </div>
    </div>
@endsection
