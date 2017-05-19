<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="964ad5f0ab4b6e32" />
    <meta name="google-site-verification" content="FLQsybZxCdEquYFvzSvRnT-02d_iV02kShDuDJC9l00" />
    <title>Скучно в пробке, заходи новости, статьи, блоги, чаты...</title>

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
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <div class="badge">{{ $common_count }}</div>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand"  href="{{ url('/') }}">
                <img src="/img/avatar.jpeg" width="100px" height="100px" border="0" class="img-circle">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @if (!Auth::guest())
                    <li>
                        <a href="{{ url('/message') }}">
                            <span class="glyphicon glyphicon-envelope"></span>
                            Почта
                            <span class="badge">{{$mail_count}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/events') }}">
                            <span class="glyphicon glyphicon-bell"></span>
                            Журнал
                            <span class="badge">{{$events_count}}</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('/users') }}">
                        <span class="glyphicon glyphicon-user"></span>
                        Пользователи
                        <span class="badge">{{$user_count}}</span>
                    </a>
                </li>
                <?php /**
                 * <li><a href="{{ url('/find') }}"><span class="glyphicon glyphicon-search"></span> Поиск</a></li>
                 */ ?>
                <li>
                    <a href="{{ url('/blogs') }}">
                        <span class="glyphicon glyphicon-book"></span> Блоги <span class="badge">{{$blog_count}}</span>
                    </a>
                </li>
                <?php /**
                <li><a href="{{ url('/chats') }}"><span class="glyphicon glyphicon-list"></span> Чаты</a></li>
                <li>
                <a href="{{ url('/files') }}">
                <span class="glyphicon glyphicon-file"></span>
                Файлы
                <span class="badge">{{$files_count}}</span>
                </a>
                </li>
                 *                  **/  ?>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Вход</a></li>
                    <li><a href="{{ url('/register') }}">Регистрация</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/myblogs') }}"><i class="fa fa-btn fa-home"></i>Мой блог</a></li>
                            <li><a href="{{ url('/home') }}"><i class="fa fa-btn fa-home"></i>Моя страница</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')
@include('layouts.snipets.footer')

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
