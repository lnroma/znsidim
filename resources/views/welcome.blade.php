@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            {!! Breadcrumbs::render('home') !!}
            <div class="panel panel-default">
                <div class="panel-heading">Привет!</div>
                <div class="panel-body">
                    Сдесь ты найдёшь своё! Новости блоги, дтп, обсуждение автомобилей.
                </div>
            </div>
            @widget("recentBlogs")
            <div class="panel panel-default">
                <div class="panel-heading">Часто задоваемые вопросы</div>
                <div class="panel-body">
                    <b>Что я полочу зарегистривовшись на вашем сайте?</b>
                    В первую очередь вы сможете, создавать свои блоги, постить новости. Обсуждать дорожную ситуацию.<br/>
                    <b>Есть ли реклама?</b>
                    Реклама отсутствует, это принципиальная позиция администрации ресурса.<br/>
                    <b>Как я могу помочь ресурсу?</b>
                    Вы можете перечислить любые доступные средства, хоть рубль хоть два, на яндекс кошелёк <b>410015204183531</b> <br/>
                    <b>Как я могу предложить свою идею развития ресурса?</b>
                    Вы можете написать мне на email: family_89@mail.ru<br/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
