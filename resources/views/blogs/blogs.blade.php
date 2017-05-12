@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! Breadcrumbs::render('blogs') !!}
                <div class="panel panel-default">
                    <div class="panel-heading">Блоги</div>
                    <div class="panel-body">
                        <a href="/myblogs" style="margin:5px; " class="btn btn-success">Написать</a>
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
            </div>
        </div>
    </div>
@endsection
