<a name="blog_{{$_blog->id}}"></a>
<div class="panel">
    <div class="panel-heading">
        <div class="text-center">
            <div class="row">
                <div class="col-sm-9">
                    <h3 class="pull-left">{{$_blog->name}}</h3>
                </div>
                <div class="col-sm-3">
                    <h4 class="pull-right">
                        <small><em>{!! str_replace(' ', '<br/>', $_blog->created_at) !!}</em></small>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        @if($_blog->main_image)
        <a href="#" class="thumbnail">
            <img alt="Image" src="{{ $_blog->main_image }}">
        </a>
        @endif
        {!! \Illuminate\Support\Str::words(strip_tags($_blog->content), 100) !!}
        <a href="/blogs/read/{{ $_blog->id }}">Читать дальше</a>
    </div>

    <div class="panel-footer">
        <span class="glyphicon glyphicon-user"></span>{!! UserHelper::getLinkById($_blog->user_id)   !!} |
        <span class="glyphicon glyphicon-comment"></span>
        <span class="badge">{{ $_blog->comments->count() }}</span> |
        <span class="glyphicon-eye-open glyphicon"></span>
        <span class="badge">{{ $_blog->viewed }}</span> |
        <a href="/blogs/like/{{$_blog->id}}/{{csrf_token()}}" class="btn btn-default"><span
                    class="glyphicon glyphicon-thumbs-up"></span></a>
        <span class="badge">{{ $_blog->like }}</span> |
        <a href="/blogs/dislike/{{$_blog->id}}/{{csrf_token()}}" class="btn btn-default"><span
                    class="glyphicon glyphicon-thumbs-down"></span></a>
        <span class="badge">{{ $_blog->dislike }}</span>
    </div>
</div>
