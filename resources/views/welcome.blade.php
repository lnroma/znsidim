@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('home') !!}
    <div class='panel panel-default'>
        <div class='panel-heading'>Что я получу от регистрации на сайте</div>
        <div class='panel-body'>В случае авторизаци/регистрации на сайте, вы сможете:</br>
            <ul>
                <li>Получать уведомления о новых коментариях в блогах</li>
                <li>Получать уведомления с форума</li>
                <li>Постить свои блоги, около айти тематики, без какой либо модерации и ограничений</li>
                <li>Общаться с другими пользователями сайта в внутреней почте</li>
                <li>По заявке получить почтовый ящик вида yourname@sidimvprobke.com или yourname@пробкиобайти.рус</li>
                <li>Создавать и комментировать темы на форуме сайта</li>
                <li>Оставить отзывы о компании</li>
                <li>Свои предложения по развитию сайта вы можете прислать на roman@sidimvprobke.com</li>
            </ul>
        </div>
    </div>
    @include('layouts.snipets.error')
    @widget("recentBlogs")
@endsection
