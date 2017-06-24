@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <h2>Создать папку для фото</h2>
    <form class="form-horizontal" method="post">
        <div class="form-group row">
            <label for="name" class="col-2 col-form-label">Име папки</label>
            <div class="col-6">
                <input class="form-control" type="text"  placeholder="Име папки" name="title" id="name">
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-2 col-form-label">Описание</label>
            <div class="col-6">
                <input class="form-control" name="description" type="text" placeholder="Описание" maxlength="300" id="description">
                <small id="descriptionHelp" class="form-text text-muted">Краткое описание</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-2 col-form-label">Пароль для папки</label>
            <div class="col-6">
                <input class="form-control" type="text" name="password" placeholder="Пароль" id="password">
                <small id="passwordHelp" class="form-text text-muted">Оставьте пустым что бы папка была доступна всем</small>
            </div>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-nav">Создать</button>
    </form>
@endsection