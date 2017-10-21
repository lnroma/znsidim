@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('readblog', $blog) !!}
    @include('layouts.snipets.error')
    <div class="container">
        <div clas='row'>
            <div class='col text-muted'>
                @if(UserHelper::getUserById($blog->user_id)->isOnline())
                    <span class="glyphicon glyphicon-user " style="color:green"></span>
                @else
                    <span class="glyphicon glyphicon-user " style="color:red"></span>
                @endif
                {!!UserHelper::getLinkById($blog->user_id)   !!},
                {{$blog->created_at}},
                Комментариев: {{ $blog->comments->count() }},
                Просмотров: {{ $blog->viewed }}
            </div>
            <div class='col-lg-12'>
                <div class='clearfix'></div>

                <h2 class='text'>{{$blog->name}}</h2>
            </div>
            <div class='col-lg-12 text-muted'>
                <div class='row'>
                    <span class="glyphicon glyphicon-tags"></span>
                    @if(count($blog->tags) > 0)
                        @foreach($blog->tags as $_tag)
                            &nbsp;  <a href="/tags/{{ $_tag->url_key }}" class="text-muted">{{ $_tag->title }}</a>,
                        @endforeach
                    @else
                        Нет тегов
                    @endif
                </div>
            </div>

            <div class='col-lg-12'>&nbsp;</div>
        </div>
        <div class='clearfix'></div>
        {!! strip_tags($blog->content, '<br><a><img><blockquote><strike><b><p><i><code><p><h2><h3><h1><h4><ul><li><ol><pre>') !!}
    </div>
    <div class="panel-footer">
        <a href="/blogs/like/{{$blog->id}}/{{csrf_token()}}" class="btn btn-sm btn-default"><span
                    class="glyphicon glyphicon-thumbs-up"></span></a>
        <span class="badge">{{ $blog->like }}</span> |
        <a href="/blogs/dislike/{{$blog->id}}/{{csrf_token()}}" class="btn btn-sm btn-default"><span
                    class="glyphicon glyphicon-thumbs-down"></span></a>
        <span class="badge">{{ $blog->dislike }}</span>
        @if(
            (!Auth::guest() && Auth::user()->id == $blog->user_id)
            || (!Auth::guest() && Auth::user()->role == 'superadmin')
        )
            <a href="/blogs/edit/{{ $blog->id }}" class="btn btn-sm btn-default"><span
                        class="glyphicon glyphicon-pencil"></span></a>
        @endif
    </div>
    {{--</div>--}}
    <h3 id="comments">Ваши комментарии</h3>
    @foreach($blog->comments as $_comment)
        @include('messages.chunks.message', array(
            'comment' => $_comment,
            'user_id' => $_comment->user_id,
            'aditional' => '',
        ))
    @endforeach
    @include('messages.chunks.user.form', [
        'action' => '/blogs/comment',
        'hiddens' => [
            'blog_id' => $blog->id,
            'name' => Auth::guest() ? 'Аноним' : Auth::user()->name,
        ],
        'name_field' => 'comment',
        'form_container' => true,
        'id_editor' => 'message',
    ])
@endsection
