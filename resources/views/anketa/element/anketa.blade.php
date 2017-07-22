<?php
/** @var \App\Models\Users\Anketa $anketa*/
$user = $anketa->getUser();
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="comment-left thumbnail">
            <img class="img-responsive user-photo" src="{{ $user->avatar }}">
        </div>
        <span class="divider">|</span>
        <strong>{!! UserHelper::getLinkById($user->id)  !!}</strong> <span class="text-muted">{{ $anketa->created_at }}</span>
        <span class="divider">|</span>
    </div>
    <div class="panel-body">
        {{$anketa->text}}<br/>
    </div>
    <div class="panel-footer">
        Пол:<?php echo  $anketa->getSexValue() ?> |
        Цель:<?php echo $anketa->getPurposeValue() ?> |
        Город: <?php echo $anketa->getCityValue() ?> |
    </div>
</div>



