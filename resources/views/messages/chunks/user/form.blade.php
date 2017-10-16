<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#edit_{{$id_editor}}">Редактировать</a></li>
    <li><a data-toggle="tab" href="#show_{{$id_editor}}">Просмотр</a></li>
</ul>
@if($form_container)
    <div class="tab-content" ng-app="myApp" ng-controller="MessageController"
         ng-init="content_{{$id_editor}}=''"
    >
        @else
            <div class="tab-content" ng-init="content_{{$id_editor}}='@if(isset($value)) {{$value}} @endif'">
    @endif
    <div id="edit_{{$id_editor}}" class="tab-pane fade in active" ng-init="picture=''">
        @if($form_container)
            <form action="{{$action}}" method="post">
                @endif
                @foreach($hiddens as $_name => $_value)
                    <input type="hidden" name="{{$_name}}" id="{{$_name}}" value="{{$_value}}"/>
                @endforeach
                <div class="form-group">
                    <div class="panel panel-default " style="margin: 0px; border-radius: 0px">
                        <div class="panel-body " style="padding: 2px">
                            <div class="btn-group pull-right" role="group" aria-label="Опции редактора"
                                 ng-init="showDetails = false"
                                 ng-init="showSmiles = false"
                            >
                                <a class="btn btn-nav" ng-click="showDetails_{{$id_editor}} = ! showDetails_{{$id_editor}}"><i
                                            class="fa fa-paperclip"
                                            aria-hidden="true"></i></a>
                                <a class="btn btn-nav" ng-click="showSmiles_{{$id_editor}} = ! showSmiles_{{$id_editor}}">
                                    <i class="fa fa-smile-o"></i>
                                </a>
                                <a class="btn btn-nav" ng-mousedown="bold('{{ $id_editor }}')"><span
                                            class="glyphicon glyphicon-bold"></span></a>
                                <a class="btn btn-nav" ng-mousedown="italic('{{ $id_editor }}')"><span
                                            class="glyphicon glyphicon-italic"></span></a>
                                <a class="btn btn-nav" ng-mousedown="strice('{{ $id_editor }}')"><i
                                            class="fa fa-strikethrough"
                                            aria-hidden="true"></i></a>

                                <a class="btn btn-nav" ng-mousedown="inputTags('<blockquote>', '</blockquote>', null, '{{ $id_editor }}')"><i
                                            class="fa fa-quote-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div  ng-class="{ 'hidden': ! showDetails_{{$id_editor}} }">
                        <div class="panel panel-default"
                             style="margin: 0px; border-radius: 0px; ">
                            <a class="pull-right" style="margin:10px; text-decoration: none"
                               ng-click="showDetails_{{$id_editor}} = ! showDetails_{{$id_editor}}"
                               href="#" onclick="return false;">X</a>
                            <div class="panel-body">
                                @if(!Auth::guest())
                                    <input type="file" name="file" id="file_upload_{{ $id_editor }}"/>
                                    <hr/>
                                    <div id="file_table_{{ $id_editor }}" style="max-height: 300px;overflow: scroll">
                                    </div>
                                    <hr/>
                                    <div class="btn-group pull-right">
                                        <a ng-click="remove('{{ $id_editor }}')" class="btn btn-nav">Удалить</a>
                                        <a ng-mousedown="upload('{{ $id_editor }}')" ng-model="file" class="btn btn-nav">Загрузить</a>
                                        <a ng-mousedown="choose_file('{{ $id_editor }}')" class="btn btn-nav">Выбрать загруженое</a>
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
                    <div class="form-group"
                         ng-init="textContent_{{$id_editor}} = '@if(isset($value)) {{$value}} @endif'">
                        <div class="btn-group smiles" role="group" aria-label="Смайлики"
                             ng-class="{ 'hidden': ! showSmiles_{{$id_editor}} }">
                            <div class="panel panel-default" style="margin: 0px; border-radius: 0px">
                                <a class="pull-right" style="margin:10px; text-decoration: none"
                                   ng-click="showSmiles_{{$id_editor}} = ! showSmiles_{{$id_editor}}"
                                   href="#" onclick="return false;">X</a>
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
                        <textarea
                                  ng-change="content_{{$id_editor}} = render('{{$id_editor}}')"
                                  ng-model="textContent_{{$id_editor}}"
                                  ng-init='smiles=<?php echo json_encode($newSmiles) ?>'
                                  id="{{ $id_editor }}"
                                  class="form-control"
                                  style="margin: 0px; border-radius: 0px"
                        ></textarea>
                    </div>
                    {{ csrf_field() }}
                    @if($form_container)
                    <div class="form-group ">
                        <button type="submit" class="pull-right btn btn-success">Отправить</button>
                    </div>
                    @endif
                    <input type="hidden" name="{{$name_field}}" id="message_back" value="<?php echo '{{content_' . $id_editor . '}}' ?>"/>
                </div>
                @if($form_container)
            </form>
        @endif
    </div>
                <div id="show_{{$id_editor}}" class="tab-pane fade">
                    <span ng-bind-html="content_{{$id_editor}} | unsafe"></span>
                </div>
@if($form_container)
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
<script type="text/javascript">
    var myApp = angular.module('myApp', []);
</script>
<script src="/js/controllers/MessageController.js"></script>
    @else
    </div>
@endif
