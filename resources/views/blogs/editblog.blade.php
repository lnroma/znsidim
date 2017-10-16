@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('myblogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Мой блог</div>
        <div class="panel-body">
            <form method="post" class="form-vertical" action="/myblogs" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label" for="name">Имя:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $blog->name }}" required>
                </div>
                <div class="form-group">
                    <img src="{{ $blog->main_image }}" height="100px">
                    <label class="control-label" for="image">Главная картинка: </label>
                    <input type="file" name="main_image" class="form-control" id="image">
                </div>
                {{ csrf_field() }}
                <input type="hidden" value="{{ $blog->id }}" name="blog_id"/>
                <div class="form-group">
                    <label class="control-label" for="comment">Пост:</label>
                    <textarea id="comment" class="form-control" name="comment">{{ $blog->content }}</textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="tags">Метки:</label>
                    <select multiple name="tags[]" class="form-control">
                        @foreach($tags as $_tag)
                            <option value="{{ $_tag->id }}">{{ $_tag->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Запостить</button>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
            removePlugins: 'font'
        };
        CKEDITOR.replace('comment', options);
    </script>
@endsection