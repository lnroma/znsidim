<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#edit">Редактировать</a></li>
    <li><a data-toggle="tab" href="#show">Просмотр</a></li>
</ul>

<div class="tab-content" ng-app="myApp" ng-controller="MessageController"
     ng-init="content=''"
>
    <div id="edit" class="tab-pane fade in active" ng-init="picture='testinghuesintg'">
        @if($form_container)
            <form action="{{$action}}" method="post">
                @endif
                @foreach($hiddens as $_name => $_value)
                    <input type="hidden" name="{{$_name}}" id="{{$_name}}" value="{{$_value}}"/>
                @endforeach
                <div class="form-group">
                    <div class="panel panel-default ">
                        <div class="panel-body " style="padding: 2px">
                            <div class="btn-group pull-right" role="group" aria-label="Опции редактора"
                                 ng-init="showDetails = false"
                                 ng-init="showSmiles = false"
                            >
                                <a class="btn btn-primary" ng-click="showDetails_{{$id_editor}} = ! showDetails_{{$id_editor}}"><i
                                            class="fa fa-paperclip"
                                            aria-hidden="true"></i></a>
                                <a class="btn btn-primary" ng-click="showSmiles_{{$id_editor}} = ! showSmiles_{{$id_editor}}">
                                    <i class="fa fa-smile-o"></i>
                                </a>
                                <a class="btn btn-primary" ng-mousedown="bold('{{ $id_editor }}')"><span
                                            class="glyphicon glyphicon-bold"></span></a>
                                <a class="btn btn-primary" ng-mousedown="italic('{{ $id_editor }}')"><span
                                            class="glyphicon glyphicon-italic"></span></a>
                                <a class="btn btn-primary" ng-mousedown="strice('{{ $id_editor }}')"><i
                                            class="fa fa-strikethrough"
                                            aria-hidden="true"></i></a>

                                <a class="btn btn-primary" ng-mousedown="inputTags('<blockquote>', '</blockquote>', null, '{{ $id_editor }}')"><i
                                            class="fa fa-quote-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="edit-hints" ng-class="{ 'hidden': ! showDetails_{{$id_editor}} }">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if(!Auth::guest())
                                    <input type="file" name="file" id="file_upload_{{ $id_editor }}"/>
                                    <hr/>
                                    <div id="file_table_{{ $id_editor }}" style="max-height: 300px;overflow: scroll">
                                    </div>
                                    <hr/>
                                    <div class="btn-group">
                                        <a ng-click="remove('{{ $id_editor }}')" class="btn btn-primary">Удалить</a>
                                        <a ng-mousedown="upload('{{ $id_editor }}')" ng-model="file" class="btn btn-primary">Загрузить</a>
                                        <a ng-mousedown="choose_file('{{ $id_editor }}')" class="btn btn-primary">Выбрать загруженое</a>
                                    </div>
                                @else
                                    <p>
                                        Отправка файлов в сообщениях, доступна только зарегистрированным пользователями.
                                        Пройдите процедуру <a href="/register">регистрации</a> или <a href="/login">авторизации</a>.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group smiles edit-hints" role="group" aria-label="Смайлики"
                             ng-class="{ 'hidden': ! showSmiles_{{$id_editor}} }">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php
                                    $smiles = glob(base_path('public/smiles/smiles/*.gif'));
                                    $smiles = array_map(function ($element) {
                                        $element = explode('/', $element);
                                        $element = end($element);
                                        return $element;
                                    }, $smiles);
                                    ?>
                                    <?php $newSmiles = array() ?>
                                    <?php foreach ($smiles as $_smile): ?>
                                    <a style="text-decoration: none;"
                                       ng-click="insertSmile(':<?php echo str_replace('.gif', '', $_smile)?>', '{{$id_editor}}')">
                                        <img src="/smiles/smiles/<?php echo $_smile ?>"/>
                                    </a>
                                    <?php $newSmiles[':' . str_replace('.gif', '', $_smile)] = '/smiles/smiles/' . $_smile ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <textarea ng-keypress="content = render()"
                                  ng-change="content = render()"
                                  ng-model="textContent"
                                  ng-init='smiles = <?php echo json_encode($newSmiles) ?>'
                                  id="{{ $id_editor }}"
                                  class="form-control"
                                  style=""
                        ></textarea>
                    </div>
                    {{ csrf_field() }}

                    @if($form_container)
                    <div class="form-group ">
                        <button type="submit" class="pull-right btn btn-success">Отправить</button>
                    </div>
                    @endif
                    <input type="hidden" name="{{$name_field}}" id="message_back" value="<?php echo '{{content}}' ?>"/>
                </div>
                @if($form_container)
            </form>
        @endif
    </div>
    <div id="show" class="tab-pane fade">
        <span ng-bind-html="content | unsafe"></span>
        <div ng-class="{ 'hidden': !show_preview }">
            Вложение:<br/>
            <img src="<?php echo '{{picture}}' ?>" height="100px">
        </div>
    </div>
</div>
<div class="clearfix"></div><br/>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
<script type="text/javascript">
    var myApp = angular.module('myApp', []);
</script>
<script src="/js/controllers/MessageController.js"></script>
