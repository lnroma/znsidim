@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! Breadcrumbs::render('events') !!}
                <div class="panel panel-default">
                    <div class="panel-heading">Журнал</div>
                    <div class="panel-body">
                        <ul id="myTab2" class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#unread">Непрочитанные</a></li>
                            <li><a data-toggle="tab" href="#all">Все</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="unread" class="tab-pane fade in active">
                                <h3>Не прочитанные</h3>
                                @include('notification.chunks._unread')
                            </div>
                            <div id="all" class="tab-pane fade">
                                <h3>Все уведомления</h3>
                                @include('notification.chunks._all')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
