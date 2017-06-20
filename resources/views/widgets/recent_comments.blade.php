<h2>Последние комментарии в блоге:</h2>
<?php /** @var $_comment \App\Models\Blogs\Comment */ ?>
@foreach($comments as $_comment)
    {{--@if($_comment->name)--}}
{{--        <b>{{ $_comment->name }}</b>--}}
    {{--@else--}}
        {{--<b>Аноним</b>--}}
    {{--@endif--}}
    {{--{!! $_comment->comment  !!}--}}
    <br/>
    @include('messages.chunks.message', array(
          'comment' => $_comment,
          'user_id' => $_comment->user_id,
          'aditional' => 'написал в <a href="/blogs/read/' . $_comment->user_blogs_id .'">' . $_comment->blog->name .'</a>'
      ))
@endforeach
