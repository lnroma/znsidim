<div class="panel panel-default">
    <div class="panel-heading">Последние блоги</div>
    <div class="panel-body">
        @foreach($blogs as $_blog)
            @include('blogs.element.blog', array('_blog' => $_blog))
        @endforeach
    </div>
</div>
