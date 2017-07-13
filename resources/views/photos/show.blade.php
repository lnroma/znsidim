@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <?php $user = UserHelper::getUserById($photo->user_id) ?>
    <?php $directory = \App\Models\Photos\Directory::find($photo->directory_id) ?>
    {!! Breadcrumbs::render('photo_show', $user->name, $user->id, $directory->title, $directory->id, $photo->file_name, $photo->id) !!}
    <h2>Просмотр фото {{ $photo->file_name }}</h2>
    <img src="{{$photo->url}}" class="img-responsive"/>
    <p>
        {{$photo->description}}
    </p>
    <a href="{{ $photo->url }}" class="btn btn-nav">Скачать</a>

    <h3 id="comments">Ваши комментарии</h3>
    @foreach($photo->comments as $_comment)
        @include('messages.chunks.message', array(
            'comment' => $_comment,
            'user_id' => $_comment->user_id,
            'aditional' => '',
        ))
    @endforeach
    <span class="clearfix">&nbsp;</span>

    <form method="post" action="/photo/comment" class="form-vertical">
        @if(!Auth::guest())
            <input type="hidden" value='{{Auth::user()->name}}' name="name">
        @else
            <div class="form-group">
                <label class="control-label" for="name">Имя:</label>
                <input type="text" name="name"
                       @if(!Auth::guest()) value='{{Auth::user()->name}}'
                       @endif class="form-control" id="name">
            </div>
        @endif
        {{ csrf_field() }}
        <input type="hidden" name="photo_id" value="{{$photo->id}}">
        <div class="form-group">
            <label class="control-label" for="comment">Коментарий:</label>
            <textarea id="comment" class="form-control" name="comment"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn  btn-nav">Комментировать</button>
        </div>
    </form>

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('comment');
    </script>
@endsection