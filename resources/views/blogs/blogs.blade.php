@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Блоги</div>
        <div class="panel-body">
            @if($blogs->count() > 0)
                @foreach($blogs as $_blog)
                    @include('blogs.element.blog', array('_blog' => $_blog))
                @endforeach
            @else
                В вашем блоге пока нет записей
            @endif
            {{$blogs->render()}}
        </div>
    </div>
@endsection
