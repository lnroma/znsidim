<a name="blog_{{$_blog->id}}"></a>
<div class="panel">
    <div class="panel-heading">
        <div class="row">
            <div class='col-lg-12 text-muted'>
                @if(UserHelper::getUserById($_blog->user_id)->isOnline())
                    <span class="glyphicon glyphicon-user " style="color:green"></span>
                @else
                    <span class="glyphicon glyphicon-user " style="color:red"></span>
                @endif
                {!!UserHelper::getLinkById($_blog->user_id)   !!},
                {{$_blog->created_at}},
                Комментариев: {{ $_blog->comments->count() }},
                Просмотров: {{ $_blog->viewed }}
            </div>
            <div class="col-lg-12">
                <h3 class="pull-left"><a href="/blogs/read/{{ $_blog->id }}">{{$_blog->name}}</a></h3>
            </div>
            <div class='col-lg-12 text-muted'>
                <div class='row'>
                    <span class="glyphicon glyphicon-tags"></span>
                    @if(count($_blog->tags) > 0)
                        @foreach($_blog->tags as $_tag)
                            &nbsp;  <a href="/tags/{{ $_tag->url_key }}" class="text-muted">{{ $_tag->title }}</a>,
                        @endforeach
                    @else
                        Нет тегов
                    @endif
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
    @if($_blog->short_description)
        {!! $_blog->short_description !!}
    @else
        {!! \Illuminate\Support\Str::words(strip_tags($_blog->content), 100) !!}
    @endif
</div>
<div class="panel-footer ">
    <a class="btn btn-default pull-right" href="/blogs/read/{{ $_blog->id }}">Читать дальше</a>
    <div class="clearfix"></div>
</div>
</div>
