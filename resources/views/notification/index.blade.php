@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('events') !!}
    @include('layouts.snipets.error')
    <h2>Журнал</h2>
    <ul id="myTab2" class="nav nav-tabs">
        <li class="active" id='unread-menu'><a href="/events">Непрочитанные</a></li>
        <li id='all-menu'><a href="/events/all">Все</a></li>
    </ul>
    <div class="tab-content">
        <div id="unread" class="tab-pane fade in active">
            <h3>Не прочитанные</h3>
            @include('notification.chunks._unread')
        </div>
    </div>
@endsection
