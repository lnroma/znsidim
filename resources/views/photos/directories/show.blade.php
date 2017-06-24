@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <h2>Фото пользователя {{$user->name}}</h2>
    @if($directory->password && !session('pass_check_' . $directory->id))
        <form method="post" action="/photos/pass/directoy/{{$directory->id}}">
            {{ csrf_field() }}
            Пароль:<input type="text" name="pass"><button class="btn btn-warning">Войти</button>
        </form>
    @elseif($directory->photos->count() == 0)
        <div class="center-block">Папка пуста</div>
    @else
        <table class="table table-bordered">
            <tbody>
            @foreach($directory->photos as $_photos)
                <tr>
                    <td width="38px">
                        <img src="{{$_photos->url}}" width="200px" />
                    </td>
                    <td width="200px">
                        <a href="/photo/show/{{$_photos->id}}">{{ $_photos->file_name }}</a>
                    </td>
                    <td>
                        {{ $_photos->description }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @can('photo_edit', [$user])
        <a href="/photos/{{$user->name}}/uploadForm" class="btn btn-nav">Загрузить фото</a>
    @endcan
@endsection