<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#edit">Редактировать</a></li>
    <li><a data-toggle="tab" href="#show">Просмотр</a></li>
</ul>

<div class="tab-content" ng-app="myApp" ng-controller="MessageController" ng-init="content=''">
    <div id="edit" class="tab-pane fade in active">
        <form action="/message/send" method="post">
            <input type="hidden" name="login" id="login" value="<?php echo $user->name ?>"
                   class="form-control"
            />
            <div class="form-group">
                <div class="btn-group" role="group" aria-label="Опции редактора">
                    <a class="btn btn-nav" ng-mousedown="bold()"><span class="glyphicon glyphicon-bold"></span></a>
                    <a class="btn btn-nav" ng-mousedown="italic()"><span class="glyphicon glyphicon-italic"></span></a>
                    <a class="btn btn-nav" ng-mousedown="strice()"><i class="fa fa-strikethrough"
                                                                      aria-hidden="true"></i></a>
                </div>
                <textarea ng-keypress="content = replaceSmile()"
                          ng-change="content = replaceSmile()"
                          ng-model="textContent"
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
            <input type="hidden" name="message" id="message_back" value="<?php echo '{{content}}' ?>">
        </form>
    </div>
    <div id="show" class="tab-pane fade">
        <span ng-bind-html="content | unsafe"></span>
    </div>
</div>
<div class="clearfix"></div><br/>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
<script type="text/javascript">
    var myApp = angular.module('myApp', []);
</script>
<script src="/js/controllers/MessageController.js"></script>
