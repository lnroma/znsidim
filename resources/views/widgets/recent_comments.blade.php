<div class="panel panel-default">
    <div class="panel-heading">Последние комментарии в блоге:</div>
    <div class="panel-body">
        <?php /** @var $_comment \App\Models\Blogs\Comment */ ?>
        @foreach($comments as $_comment)
                <hr/>
            <?php  echo UserHelper::getLinkById($_comment->user_id) . ' написал в <a href="/blogs/read/' . $_comment->user_blogs_id . '">' . $_comment->blog->name . '</a>' ?>
            {{--    @include('messages.chunks.message', array(--}}
            {{--'comment' => $_comment,--}}
            {{--'user_id' => $_comment->user_id,--}}
            {{--'aditional' => 'написал в <a href="/blogs/read/' . $_comment->user_blogs_id .'">' . $_comment->blog->name .'</a>'--}}
            {{--))--}}
        @endforeach
    </div>
</div>
