<form  action="/message/send" method="post">
    <input type="hidden" name="login" id="login" value="<?php echo $user->name ?>"
           class="form-control"/>
    <div class="form-group">
        <textarea name="message" id="message" class="form-control"></textarea>
    </div>
    {{ csrf_field() }}
    <div class="form-group ">
        <button type="submit" class="pull-right btn btn-success">Отправить</button>
    </div>
</form>
<div class="clearfix"></div><br/>