@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('readblog', $blog) !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>{{$blog->name}}</h2>
        </div>
        <div class="panel-body">
            {!! $blog->content !!}
        </div>
        <div class="panel-footer">
            <span class="glyphicon glyphicon-user"></span>{!!UserHelper::getLinkById($blog->user_id)   !!} |
            <span class="glyphicon glyphicon-comment"></span>
            <span class="badge">{{ $blog->comments->count() }}</span> |
            <span class="glyphicon-eye-open glyphicon"></span>
            <span class="badge">{{ $blog->viewed }}</span> |
            <a href="/blogs/like/{{$blog->id}}/{{csrf_token()}}" class="btn btn-default"><span
                        class="glyphicon glyphicon-thumbs-up"></span></a>
            <span class="badge">{{ $blog->like }}</span> |
            <a href="/blogs/dislike/{{$blog->id}}/{{csrf_token()}}" class="btn btn-default"><span
                        class="glyphicon glyphicon-thumbs-down"></span></a>
            <span class="badge">{{ $blog->dislike }}</span>
            @if(
                (!Auth::guest() && Auth::user()->id == $blog->user_id)
                || (!Auth::guest() && Auth::user()->role == 'superadmin')
            )
                <a href="/blogs/edit/{{ $blog->id }}" class="btn btn-default"><span
                            class="glyphicon glyphicon-pencil"></span></a>
            @endif
            Теги:
            @foreach($blog->tags as $_tag)
                <a href="/tags/{{ $_tag->url_key }}" class="btn-sm btn-primary">{{ $_tag->title }}</a>
            @endforeach
        </div>
        {{--</div>--}}
        <h3>Ваши комментарии</h3>
        @foreach($blog->comments as $_comment)
            @include('messages.chunks.message', array(
                'comment' => $_comment,
                'user_id' => $_comment->user_id,
            ))
        @endforeach
        <div class="panel panel-default">
            <div class="panel-heading">
                Оставить комментарий
            </div>
            <div class="panel-body">
                <form method="post" action="/blogs/comment" class="form-vertical">
                    @if(!Auth::guest())
                        <input type="hidden" value='{{Auth::user()->name}}' name="name">
                    @else
                        <div class="form-group">
                            <label class="control-label" for="name">Имя:</label>
                            <input type="text" name="name"
                                   @if(!Auth::guest()) value='{{Auth::user()->name}}'
                                   @endif class="form-control" id="name">
                        </div>
                    @endif
                    {{ csrf_field() }}
                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                    <div class="form-group">
                        <label class="control-label" for="comment">Коментарий:</label>
                        <textarea id="comment" class="form-control" name="comment"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Комментировать</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('comment');
        </script>
@endsection
