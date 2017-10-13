<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#edit">Редактировать</a></li>
    <li><a data-toggle="tab" href="#show">Просмотр</a></li>
</ul>

<div class="tab-content" ng-app="myApp" ng-controller="MessageController"
     ng-init="content=''"
>
    <div id="edit" class="tab-pane fade in active" ng-init="picture='testinghuesintg'">
        <form action="/message/send" method="post">
            <input type="hidden" name="login" id="login" value="<?php echo $user->name ?>"
                   class="form-control"
            />
            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Опции редактора" ng-init="showDetails = false"
                     ng-init="showSmiles = false">
                    <a class="btn btn-nav" ng-click="showDetails = ! showDetails"><i
                                class="fa fa-paperclip"
                                aria-hidden="true"></i></a>
                    <a class="btn btn-nav" ng-click="showSmiles = ! showSmiles">
                        <i class="fa fa-smile-o"></i>
                    </a>
                    <a class="btn btn-nav" ng-mousedown="bold()"><span
                                class="glyphicon glyphicon-bold"></span></a>
                    <a class="btn btn-nav" ng-mousedown="italic()"><span
                                class="glyphicon glyphicon-italic"></span></a>
                    <a class="btn btn-nav" ng-mousedown="strice()"><i
                                class="fa fa-strikethrough"
                                aria-hidden="true"></i></a>

                    <a class="btn btn-nav" ng-mousedown="inputTags('<blockquote>', '</blockquote>')"><i
                                class="fa fa-quote-right"></i></a>
                </div>
                <div class="edit-hints" ng-class="{ 'hidden': ! showDetails }">
                    <input type="file" name="file" id="file_upload"/>
                    <a ng-click="remove()" class="btn btn-primary">Удалить</a>
                    <a ng-mousedown="upload()" ng-model="file" class="btn btn-primary">Загрузить</a>
                </div>
                <div class="form-group">
                    <div class="btn-group smiles edit-hints" role="group" aria-label="Смайлики"
                         ng-class="{ 'hidden': ! showSmiles }">
                        <?php $newSmiles = array() ?>
                        <?php foreach ($smiles as $_smile): ?>
                        <a class="btn btn-default"
                           ng-click="insertSmile(':<?php echo str_replace('.gif', '', $_smile)?>')">
                            <img src="/smiles/smiles/<?php echo $_smile ?>"/>
                        </a>
                        <?php $newSmiles[':' . str_replace('.gif', '', $_smile)] = '/smiles/smiles/' . $_smile ?>
                        <?php endforeach; ?>
                    </div>
                    <textarea ng-keypress="content = render()"
                              ng-change="content = render()"
                              ng-model="textContent"
                              ng-init='smiles = <?php echo json_encode($newSmiles) ?>'
                              id="message"
                              class="form-control"
                              style=""
                              id="editor"
                    ></textarea>
                </div>
                {{ csrf_field() }}
                <div class="form-group ">
                    <button type="submit" class="pull-right btn btn-success">Отправить</button>
                </div>
                <input type="hidden" name="message" id="message_back" value="<?php echo '{{content}}' ?>"/>
                <img src="<?php echo '{{picture}}' ?>" height="100px" ng-class="{ 'hidden': !show_preview }">
            </div>

        </form>
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
