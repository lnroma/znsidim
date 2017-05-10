<div class="panel panel-info">
    <div class="panel-heading">
        {{$_blog->name}}
    </div>
    <div class="panel panel-body">
        {{strip_tags(substr($_blog->content, 0, 300))}}...
    </div>
    <div class="panel-footer">
        <div class="btn-group" role="group" arial-label="Управление">
            <a href="/blogs/read/{{$_blog->id}}" class="btn btn-info">Читать</a>
        </div>
    </div>
</div>