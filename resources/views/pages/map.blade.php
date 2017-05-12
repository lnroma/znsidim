@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Карта сайта</div>

                    <div class="panel-body">
                        <h2>Сдесь вы найдёте </h2>
                        <p>Интересующий раздел</p>
                        <ul class="list-group-item-info">
                            <li><a href="/">Главная</a>
                                <ul>
                                    <li><a href="/users/">Пользователи</a></li>
                                    <li><a href="/blogs">Блоги</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
