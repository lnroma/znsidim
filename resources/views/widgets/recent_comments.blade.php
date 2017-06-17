<h2>Последние комментарии в блоге:</h2>
<?php /** @var $_comment \App\Models\Blogs\Comment */ ?>
@foreach($comments as $_comment)
    <div class="panel panel-default">
        <div class="panel-heading">
            @if($_comment->name)
                <b>{{ $_comment->name }}</b>
            @else
                <b>Аноним</b>
            @endif
            написал в <a href="/blogs/read/{{$_comment->user_blogs_id}}">{{ $_comment->blog->name }}</a>
        </div>
        <div class="panel-body">
            {!! $_comment->comment  !!}
        </div>
    </div>
    <br/>
@endforeach
