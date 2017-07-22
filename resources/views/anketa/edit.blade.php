@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('mypage') !!}
    @include('layouts.snipets.error')
    <h2>Для знакомства</h2>
    <form method="post">
        <div class="form-group">
            <label for="is_enable">Показывать в знакомствах:</label>
            <select class="form-control" id="is_enable" name="is_enable">
                <option value="0" @if(!$ankets->is_enable) selected @endif>Нет</option>
                <option value="1" @if($ankets->is_enable) selected @endif>Да</option>
            </select>
        </div>
        <div class="form-group">
            <label for="text">Тест объявления:</label>
            <textarea name="text" id="text" class="form-control">{{$ankets->text}}</textarea>
        </div>
        <div class="form-group">
            <label for="sex">Пол:</label>
            <select class="form-control" id="sex" name="sex">
                @foreach($ankets->getSex() as $_sex)
                    <option @if ($ankets->sex == $_sex->id) selected="true" @endif value="{{$_sex->id}}">{{$_sex->value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="city">Город:</label>
            <select class="form-control" id="city" name="city_id">
                @foreach($ankets->getAllCity() as $_city)
                    <option @if ($ankets->city_id == $_city->id) selected="true" @endif value="{{$_city->id}}">{{$_city->value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="city">Цель:</label>
            <select class="form-control" id="purpose" name="purpose_id">
                @foreach($ankets->getPurpose() as $_purpose)
                    <option @if ($ankets->purpose_id == $_purpose->id) selected="true" @endif value="{{$_purpose->id}}">
                        {{$_purpose->value}}</option>
                @endforeach
            </select>
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-default">Сохранить</button>
    </form>
@endsection