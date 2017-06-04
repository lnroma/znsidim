<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="964ad5f0ab4b6e32"/>
    <meta name="google-site-verification" content="FLQsybZxCdEquYFvzSvRnT-02d_iV02kShDuDJC9l00"/>
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}"/>
    <meta name="keywords" content="{{ $keywords }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
          integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/style/main.css">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="btn-group btn-group-justified" role="group">
                @if (!Auth::guest())
                    <a href="{{ url('/message') }}" class="btn  btn-primary">
                        <span class="glyphicon glyphicon-envelope"></span>
                        <span class="badge">{{$mail_count}}</span>
                    </a>
                    <a href="{{ url('/events') }}" class="btn  btn-primary">
                        <span class="glyphicon glyphicon-bell"></span>
                        <span class="badge">{{$events_count}}</span>
                    </a>
                @endif
                <a href="{{ url('/users') }}" class="btn  btn-primary">
                    <span class="glyphicon glyphicon-user"></span>
                    <span class="badge">{{$user_count}}</span>
                </a>
                @if (Auth::guest())
                    <a href="{{ url('/login') }}" class="btn  btn-primary">Вход</a>
                    <a href="{{ url('/register') }}" class="btn  btn-primary">Регистрация</a>
                    <a href="{{ GoogleHelper::getAuthUrl() }}" class="btn btn-warning">Google+</a>
                @else
                    <a href="{{ url('/myblogs') }}" class="btn  btn-primary"><span
                                class="glyphicon glyphicon-pencil"></span></a>
                    <a href="{{ url('/home') }}" class="btn  btn-primary"><i class="fa fa-btn fa-home"></i></a>
                    <a href="{{ url('/logout') }}" class="btn  btn-primary"><i class="fa fa-btn fa-sign-out"></i></a>
                @endif
            </div>
            <div class="panel-footer">
                <a href="/forum" class="btn btn-default"><span class="glyphicon glyphicon-megafon"></span>Форум</a>
                <a href="/blogs" class="btn btn-default"><span class="glyphicon glyphicon-book"></span>Блоги<span class="badge">{{$blog_count}}</span></a>
                <a href="/tags" class="btn btn-default">Теги</a>
            </div>
            @yield('content')
            @include('layouts.snipets.metrika')
            @if(!Auth::guest() && Auth::user()->role == 'superadmin')
                <form method="post" action="/seo/save">
                    {{ csrf_field() }}
                    <input type="text" name="url" value="{{ $_SERVER['REQUEST_URI'] }}"></br>
                    <input type="text" name="title" value="{{ $title }}"><br>
                    <textarea name="description" style="width: 100%">{{ $description }}</textarea><br/>
                    <textarea name="keywords" style="width: 100%">{{ $keywords }}</textarea><br/>
                    <input type="submit" name="ok">
                </form>
            @endif
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
        integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
