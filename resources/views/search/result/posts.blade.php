@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('blogs') !!}
    @include('layouts.snipets.error')
    <h2>Результаты поиска по форуму {{$total}}</h2>
    @if($total > 0)
        <ul>
            @foreach($threads as $_thread)
                <li>
                    <a href="{{ Forum::route('category.show', $_thread->category) }}">{{$_thread->category->title}}</a>
                    <a href="{{ Forum::route('thread.show', $_thread) }}">{{$_thread->title}}</a>
                </li>
            @endforeach
        </ul>
        {{$threads->render()}}
    @else
        Ничего не найденно
    @endif
@endsection
