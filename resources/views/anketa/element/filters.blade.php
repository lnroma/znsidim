<?php
$ankets = new \App\Models\Users\Anketa();
$filters = session('filters');
?>
<form id='filter' class="form-vertical" method="post" action="/anketa/saveFilters">
    <div class="form-group">
        <label for="sex">Пол:</label>
        <select class="form-control" id="sex" name="sex">
            <option value="-1">Не важно</option>
            @foreach($ankets->getSex() as $_sex)
                <option @if ($ankets->sex == $filters['sex']) selected="true"
                        @endif value="{{$_sex->id}}">{{$_sex->value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="city">Город:</label>
        <select class="form-control" id="city" name="city_id">
            <option value="-1">Любой город</option>
            @foreach($ankets->getAllCity() as $_city)
                <option @if ($ankets->city_id == $filters['city_id']) selected="true"
                        @endif value="{{$_city->id}}">{{$_city->value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="city">Цель:</label>
        <select class="form-control" id="purpose" name="purpose_id">
            <option value="-1">Любая</option>
            @foreach($ankets->getPurpose() as $_purpose)
                <option @if ($ankets->purpose_id == $filters['purpose_id']) selected="true"
                        @endif value="{{$_purpose->id}}">
                    {{$_purpose->value}}</option>
            @endforeach
        </select>
    </div>
    {{ csrf_field() }}
</form>
<button type="submit" class="btn btn-default" onclick="$('#filter').submit()">Сохранить</button>
<a href="/anketa/clearFilters" class="btn btn-default">Сбросить фильтры</a>
