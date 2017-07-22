@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <h2>Теги</h2>
    <div class="row">
        @if($tags->count() > 0)
            <?php $i = 0 ?>
            @foreach($tags as $_tag)
                @if($i%3 == 0)
    </div>
    <div class="row">
        @endif
        <div class="col-lg-3">
            <h2>{{ $_tag->title }}</h2>
            <p>{{ $_tag->description }}</p>
            <p>
                <a class="btn-primary btn" href="/tags/{{ $_tag->url_key }}">Блоги тега <span
                            class="badge">{{ $_tag->blogs->count() }}</span></a>
            </p>
        </div>
        {{ $_tag->name }}
        <?php $i++ ?>
        @endforeach
        @else
            Тегов нет
        @endif
        @can('create-tags')
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Создать тэг
                </div>
                <div class="panel-body">
                    <form action="/tags" method="post">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input id="title" class="form-control" type="text" name="title"/>
                        </div>
                        <div class="form-group">
                            <label for="url_key">Url key:</label>
                            <input id="url_key" class="form-control" type="text" name="url_key"/>
                        </div>
                        <div class="form-group">
                            <label for="desc">Description:</label>
                            <input id="desc" class="form-control" type="text" name="description"/><br>
                        </div>
                        {!! csrf_field() !!}
                        <input type="submit" name="ok" value="ok"/>
                    </form>
                </div>
            </div>
        @endcan
    </div>
@endsection
