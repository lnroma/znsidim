@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <h2>Просмотр фото {{ $photo->file_name }}</h2>
    <img src="{{$photo->url}}" class="img-responsive" />
    <p>
        {{$photo->description}}
    </p>
    <a href="{{ $photo->url }}" class="btn btn-nav">Скачать</a>
@endsection