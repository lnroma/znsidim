<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="964ad5f0ab4b6e32"/>
    <meta name="google-site-verification" content="FLQsybZxCdEquYFvzSvRnT-02d_iV02kShDuDJC9l00"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon"/>
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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css"/>
    <style>
        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<div class='row'>
    <nav class="navbar navbar-fixed-top navbar-default sidebar" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-sidebar-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/forum"><span class="glyphicon glyphicon-megafon"></span>Форум</a></li>
                    <li><a href="/blogs"><span class="glyphicon glyphicon-book"></span>Блоги<span
                                    class="badge">{{$blog_count}}</span></a></li>
                    <li><a href="/tags"><span class="glyphicon glyphicon-tags"></span> Теги</a></li>
                    <li><a href="{{ url('/users') }}">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="badge">{{$user_count}}</span>
                        </a></li>
                    <li><a href="/feed"><i class="fa fa-btn fa-rss"></i>RSS</a></li>
                    <li><a href="/search"><span class="glyphicon glyphicon-search"></span> Поиск</a></li>
                    <li><a href="/dating"><span class="glyphicon glyphicon-heart"></span> Знакомство</a></li>
                    <li><a href="/games"><i class="fa fa-gamepad"></i>
                            Игры денди!</a></li>
                </ul>
            </div>
        </div>
    </nav>
    &nbsp; <br/>
    &nbsp; <br/>
    &nbsp; <br/>
    <div class="clear-fix"></div>
    <div class='col-md-1'></div>
    <div class='col-md-10'>
        <div class="row">
            <div class="col-lg-9 nopadding">
                @if($mail_count)
                    <div class="alert alert-warning">У вас новое сообщение в <a href="{{ url('/message') }}">почте</a>
                    </div>
                @endif
                @yield('content')
            </div>
            <div class="col-lg-3 nopadding">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Меню пользователя
                    </div>
                    <div class="panel-body">
                        <ul class="nav">
                            @if (!Auth::guest())
                                <li>
                                    <center>
                                        <img src="<?php echo Auth::user()->avatar ?>" class="img-circle" width="100px"
                                             height="100px">
                                    </center>
                                </li>
                                <li><a href="{{ url('/message') }}">
                                        <span class="glyphicon glyphicon-envelope"></span>
                                        Сообщения
                                        <span class="badge pull-right">{{$mail_count}}</span>
                                    </a></li>
                                <li><a href="{{ url('/events') }}">
                                        <span class="glyphicon glyphicon-bell"></span>
                                        Журнал
                                        <span class="badge pull-right">{{$events_count}}</span>
                                    </a></li>
                            @endif
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Вход</a>
                                </li>
                                <li><a href="{{ url('/register') }}">Регистрация</a>
                                </li>
                                <li>
                                    <a href="{{ GoogleHelper::getAuthUrl() }}">Google+</a>
                                </li>
                            @else
                                <li><a href="{{ url('/myblogs') }}"><span
                                                class="glyphicon glyphicon-pencil"></span>
                                        Написать</a></li>
                                <li><a href="{{ url('/home') }}"><i
                                                class="fa fa-btn fa-home pull-left"></i>
                                        Домой
                                    </a></li>
                                <li><a href="{{ url('/logout') }}"><i
                                                class="fa fa-btn fa-sign-out "></i>
                                        Выйти</a></li>
                                <li><a href="{{ url('/user/show') }}/{{ Auth::user()->name }}">Анкета</a></li>
                                <li><a href="{{ url('/photos/') }}/{{ Auth::user()->name }}">Фотоальбом</a></li>
                            @endif
                        </ul>
                    </div>
                    {{--</div>--}}
                </div>
                @widget("recentActive")
                @if(Auth::guest())
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            В случае авторизаци/регистрации на сайте, вы сможете:
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>Получать уведомления о новых коментариях в блогах</li>
                                <li>Получать уведомления с форума</li>
                                <li>Постить свои блоги, около айти тематики, без какой либо модерации и ограничений</li>
                                <li>Общаться с другими пользователями сайта в внутреней почте</li>
                                <li>По заявке получить почтовый ящик вида yourname@sidimvprobke.com или yourname@
                                    пробкиобайти.рус
                                </li>
                                <li>Создавать и комментировать темы на форуме сайта</li>
                                <li>Оставить отзывы о компании</li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(!Auth::guest() && Auth::user()->role == 'superadmin')
            <div class="panel panel-default">
                <div class="panel-heading">
                    Seo настройка страницы
                </div>
                <div class="panel-body">
                    <form method="post" action="/seo/save">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="url">Url:</label>
                            <input class="form-control" id="url" type="text" name="url"
                                   value="{{ $_SERVER['REQUEST_URI'] }}">
                        </div>
                        <div class="form-group">
                            <label for="title">Заголовок страницы:</label>
                            <input id="title" class="form-control" type="text" name="title" value="{{ $title }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Описание:</label>
                            <textarea name="description" id="description"
                                      class="form-control">{{ $description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <textarea id="keywords" name="keywords" class="form-control">{{ $keywords }}</textarea>
                        </div>
                        <input type="submit" name="ok">
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
</div>
<footer class="footer">
    @include('layouts.snipets.metrika')
</footer>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
        integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/main.js"></script>
<script src="/js/bootstrap-select.js"></script>
<script type="text/javascript">
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() != 0) {
                $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });
        $('#toTop').click(function () {
            $('body,html').animate({scrollTop: 0}, 800);
        });
    });
</script>
<a href='#' class='btn btn-success' id='toTop'> Наверх ^ </a>
</body>
</html>
