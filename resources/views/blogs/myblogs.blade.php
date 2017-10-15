@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('myblogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Мой блог</div>
        <div class="panel-body">
            <form method="post" class="form-vertical" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label" for="name">Имя:</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label" for="comment">Короткое описание:</label>
                    @include('messages.chunks.user.form', [
                            'action' => '/',
                            'hiddens' => [],
                            'name_field' => 'short_description',
                            'form_container' => false,
                            'id_editor' => 'short_description',
                        ])
                </div>
                <div class="form-group">
                    <label class="control-label" for="comment">Пост:</label>
                    @include('messages.chunks.user.form', [
                            'action' => '/',
                            'hiddens' => [],
                            'name_field' => 'comment',
                            'form_container' => false,
                            'id_editor' => 'comment',
                        ])
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
            @if($blogs->count() > 0)
                @foreach($blogs as $_blog)
                    @include('blogs.element.blog', array('_blog' => $_blog))
                @endforeach
            @else
                В вашем блоге пока нет записей
            @endif
            {{$blogs->render()}}
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
//        CKEDITOR.replace('comment', options);
//        CKEDITOR.replace('short_description', options);
    </script>
@endsection
