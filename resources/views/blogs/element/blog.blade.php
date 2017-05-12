<div class="panel panel-info">
    <div class="panel-heading">
        {{$_blog->name}} | {{$_blog->created_at}} | {!!UserHelper::getLinkById($_blog->user_id)   !!}
    </div>
    <div class="panel panel-body">
        {!!$_blog->content!!}
    </div>
    <div class="panel-footer">
        <div class="btn-group" role="group" arial-label="Управление">
            <a href="/blogs/read/{{$_blog->id}}" class="btn btn-info">Комментировать <span class="badge">{{ $_blog->comments->count() }}</span></a>
        </div>
    </div>
</div>
