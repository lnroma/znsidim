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
    Комментарий:
    @include('messages.chunks.user.form', [
        'action' => '/photo/comment',
        'hiddens' => [
            'login' => $user->name,
            'name' => Auth::guest() ? 'Аноним' : Auth::user()->name,
            'photo_id' => $photo->id,
        ],
        'name_field' => 'comment',
        'form_container' => true,
        'id_editor' => 'message',
    ])
@endsection