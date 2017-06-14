<h2> Последние блоги </h2>
        @foreach($blogs as $_blog)
            @include('blogs.element.blog', array('_blog' => $_blog))
        @endforeach
