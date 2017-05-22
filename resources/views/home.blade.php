@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('mypage') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Анкета</div>
        <div class="panel-body">
            <img src="{{ Auth::user()->avatar }}" class="center-block" height="200px">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar" class="control-label col-sm-4">Аватар</label>
                    <div class="col-sm-8">
                        <input type="file" name="avatar" id="avatar"/>
                    </div>
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <label for="hello" class="control-label col-sm-4">Приветствие</label>
                    <div class="col-sm-8">
                        <input type="text" name="hello" id="hello" value="{{ Auth::user()->hello }}"
                               class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="about_me" class="control-label col-sm-4">Обо мне</label>
                    <div class="col-sm-8">
                        <textarea name="about_me" id="about_me"
                                  class="form-control">{{trim(Auth::user()->about_me)}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="birthday" class="control-label col-sm-4">День рождения</label>
                    <div class="col-sm-8">
                        <input type="text" id='birthday' name="birthday" class="form-control"
                               value="{{ Auth::user()->birthday}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="/user/show/{{Auth::user()->name}}" class="btn btn-info" target="_blank">Мая анкета</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.onload = function () {
            $("#birthday").datepicker();
        };
    </script>
@endsection
