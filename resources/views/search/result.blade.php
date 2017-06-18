@extends('layouts.app')

@section('content')
    <h2>Результаты поиска: {{$query}}</h2>
    <hr/>
    Всего найденно ({{$common}})
    <hr/>
    <ul>
        <li><a href="/search/result/blog/{{$query}}">В блоге ({{$blog}})</a></li>
        <li><a href="/search/result/user/{{$query}}">В пользователях ({{$user}})</a></li>
        <li><a href="/search/result/forum/{{$query}}">В форуме ({{$forum}})</a></li>
    </ul>
@endsection
