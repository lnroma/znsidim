@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Теги</div>
        <div class="panel-body">
            <div class="row">
                @if($tags->count() > 0)
                    <?php $i=0 ?>
                    @foreach($tags as $_tag)
                        @if($i%3 == 0)
                            </div><div class="row">
                        @endif
                        <div class="col-lg-3">
                            <h2>{{ $_tag->title }}</h2>
                            <p>{{ $_tag->description }}</p>
                            <p>
                                <a class="btn-primary btn" href="/tags/{{ $_tag->url_key }}">Блоги тега <span class="badge">{{ $_tag->blogs->count() }}</span></a>
                            </p>
                        </div>
                        {{ $_tag->name }}
                        <?php $i++ ?>
                    @endforeach
                @else
                    Тегов нет
                @endif
                @can('create-tags')
                    <form action="/tags" method="post">
                        Title:<input type="text" name="title" /><br>
                        Url-key:<input type="text" name="url_key" /><br>
                        Description:<input type="text" name="description"/><br>
                        {!! csrf_field() !!}
                        <input type="submit" name="ok" value="ok"/>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
