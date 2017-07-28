<?php
$ankets = new \App\Models\Users\Anketa();
$filters = session('filters');
?>
<form id='filter' class="form-inline" method="post" action="/anketa/saveFilters">
    <div class="form-group">
        <label for="sex">Пол:</label>
        <select class="selectpicker " style="display: none;" id="sex" name="sex">
            <option value="-1">Не важно</option>
            @foreach($ankets->getSex() as $_sex)
                <option @if ($_sex->id == $filters['sex']) selected="true"
                        @endif value="{{$_sex->id}}">{{$_sex->value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="city">Город:</label>
        <select  class="selectpicker " style="display: none;" data-live-search="true" id="city" name="city_id">
            <option data-tokens="все" value="-1">Любой город</option>
            @foreach($ankets->getAllCity() as $_city)
                <option data-tokens="<?php echo strtolower($_city->value) ?>" @if ($_city->id == $filters['city_id']) selected="true"
                        @endif value="{{$_city->id}}">{{$_city->value}}</option>
            @endforeach
        </select>

    </div>
    <div class="form-group">
        <label for="purpose">Цель:</label>
        <select class="selectpicker " style="display: none;" id="purpose" name="purpose_id">
            <option value="-1">Любая</option>
            @foreach($ankets->getPurpose() as $_purpose)
                <option @if ($_purpose->id == $filters['purpose_id']) selected="true"
                        @endif value="{{$_purpose->id}}">
                    {{$_purpose->value}}</option>
            @endforeach
        </select>
    </div>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-success" onclick="$('#filter').submit()">Применить</button>
</form>
<span class="clear-fix">&nbsp;<br/></span>
<a href="/anketa/clearFilters" class="btn btn-warning">Сбросить</a>
