@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Личный кабинет {{Auth::user()->name}}</div>
        <div class="panel-body">
            <form class="form-horizontal" action="/message/send" method="post">
                <div class="form-group">
                    <label for="login" class="control-label col-sm-4">Получатель</label>
                    <div class="col-sm-8">
                        <input type="text" name="login" id="login" value="{{$login}}" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="control-label col-sm-4">Сообщение</label>
                    <div class="col-sm-8">
                        <textarea name="message" id="message" class="form-control"></textarea>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection