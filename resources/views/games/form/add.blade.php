@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Список игр денди</div>
        <div class="panel-body">
            <form method="post" action="" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Имя игры:</label>
                    <input class="form-control" id="name" type="text" name="name">
                </div>
                <div class="form-group">
                    <label for="description_top">Описание с верху:</label>
                    <textarea name="description_top" id="description_top" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="description_bottom">Описание с низу:</label>
                    <textarea name="description_bottom" id="description_bottom" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="short_description">Короткое описание:</label>
                    <textarea name="short_description" id="short_description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="type">Тип игры:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="nes">NES</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="rom">РОМ: </label>
                    <input type="file" name="rom" class="form-control" id="rom">
                </div>
                <input type="submit" name="Сохранить">
            </form>
        </div>
    </div>
@endsection