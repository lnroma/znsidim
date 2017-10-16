@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('myblogs') !!}
    @include('layouts.snipets.error')
    <div class="panel panel-default">
        <div class="panel-heading">Мой блог</div>
        <div class="panel-body">
            <form method="post" class="form-vertical" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label" for="name">Имя:</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>

                <div class="tab-content" ng-app="myApp" ng-controller="MessageController"
                     ng-init="content=''"
                >
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label" for="comment">Короткое описание:</label>
                    @include('messages.chunks.user.form', [
                            'action' => '/',
                            'hiddens' => [],
                            'name_field' => 'short_description',
                            'form_container' => false,
                            'id_editor' => 'short_description',
                        ])
                </div>
                <div class="form-group">
                    <label class="control-label" for="comment">Пост:</label>
                    @include('messages.chunks.user.form', [
                            'action' => '/',
                            'hiddens' => [],
                            'name_field' => 'comment',
                            'form_container' => false,
                            'id_editor' => 'comment',
                        ])
                </div>
                <div class="form-group">
                    <label class="control-label" for="tags">Метки:</label>
                    <select multiple name="tags[]" class="form-control">
                        @foreach($tags as $_tag)
                            <option value="{{ $_tag->id }}">{{ $_tag->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="clearfix"></div><br/>
                </div>

                <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
                <script type="text/javascript">
                    var myApp = angular.module('myApp', []);
                </script>
                <script src="/js/controllers/MessageController.js"></script>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Запостить</button>
                </div>
            </form>
            @if($blogs->count() > 0)
                @foreach($blogs as $_blog)
                    @include('blogs.element.blog', array('_blog' => $_blog))
                @endforeach
            @else
                В вашем блоге пока нет записей
            @endif
            {{$blogs->render()}}
        </div>
    </div>
@endsection
