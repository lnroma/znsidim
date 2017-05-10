@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! Breadcrumbs::render('readblog', $blog) !!}
                <div class="panel panel-default">
                    <div class="panel-heading">Блог</div>
                    <div class="panel-body">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h2>{{$blog->name}}</h2>
                            </div>
                            <div class="panel-body">
                                {!! $blog->content !!}
                            </div>
                            <div class="panel-footer">
                                <span class="badge badge-pill badge-success">Просмотры {{$blog->viewed}}</span>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Коментарии
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <tbody>
                                    @foreach($blog->comments as $_comment)
                                        <tr>
                                            <td>{{$_comment->name}}: {!! $_comment->comment !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Оставить комментарий
                            </div>
                            <div class="panel-body">
                                <form method="post" action="/blogs/comment" class="form-vertical">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Имя:</label>
                                        <input type="text" name="name"
                                               @if(!Auth::guest()) value='{{Auth::user()->name}}'
                                               @endif class="form-control" id="name">
                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'comment' );
    </script>
@endsection
