@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Вход</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                {{--<div class="col-md-6">--}}
                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">--}}

                {{--@if ($errors->has('email'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('email') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Логин</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>Логин не найден</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Пароль</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>Неверный пароль</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Запомнить меня
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> Вход
                        </button>
                        <a href="{{ GoogleHelper::getAuthUrl() }}" class="btn btn-warning">Авторизоваться через G+</a>
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
