@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! Breadcrumbs::render('myblogs') !!}
                <div class="panel panel-default">
                    <div class="panel-heading">Мой блог</div>
                    <div class="panel-body">
                        <form method="post" class="form-vertical">
                            <div class="form-group">
                                <label class="control-label" for="name">Имя:</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label" for="comment">Записка:</label>
                                <textarea id="comment" class="form-control" name="comment"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Запостить</button>
                            </div>
                        </form>
                        @if($blogs->count() > 0)
                            @foreach($blogs as $_blog)
                                @include('blogs.element.blog', array('_blog' => $_blog))
                                <hr/>
                                {{$blogs->render()}}
                            @endforeach
                        @else
                            В вашем блоге пока нет записей
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace( 'comment', options );
    </script>
@endsection
