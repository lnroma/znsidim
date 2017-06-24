@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <h2>Создать папку для фото</h2>
    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="name" class="col-2 col-form-label">Выберите фаил</label>
            <div class="col-6">
                <input class="form-control" type="file" placeholder="Выберите фаил" name="file" id="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-2 col-form-label">Описание</label>
            <div class="col-6">
                <input class="form-control" name="description" type="text" placeholder="Описание" maxlength="300"
                       id="description">
                <small id="descriptionHelp" class="form-text text-muted">Краткое описание</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="directory" class="col-2 col-form-label">Папка для фото</label>
            <div class="col-6">
                <select class="form-control" type="text" name="directory" id="directory">
                    @foreach($user->directories as $_directory)
                        <option value="{{$_directory->id}}">{{$_directory->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-nav">Загрузить</button>
    </form>
@endsection