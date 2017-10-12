@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('photo', $user->name, $user->id) !!}
    @include('layouts.snipets.error')
    <h2>Фото пользователя {{$user->name}}</h2>
    <table class="table table-bordered">
        <tbody>
        @foreach($user->directories as $_directory)
            <tr>
                <td width="38px">
                    @if($_directory->password)
                        <span class="glyphicon glyphicon-folder-close"></span>
                    @else
                        <span class="glyphicon glyphicon-folder-open"></span>
                    @endif
                </td>
                <td width="200px">
                    <a href="/photos/{{$user->name}}/directory/{{$_directory->id}}">{{ $_directory->title }}</a>
                </td>
                <td>
                    {{ $_directory->description }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @can('photo_edit', [$user])
        <a href="/photos/{{$user->name}}/uploadForm" class="btn btn-nav">Загрузить фото</a>
        <a href="/photos/{{$user->name}}/createDirectory" class="btn btn-nav">Создать папку</a>
    @endcan
@endsection