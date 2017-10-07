@extends('layouts.app')

@section('content')
    @include('layouts.snipets.error')
    <h1>Настройка почты:</h1>
    <form  method="post">
        <div class="form-group">
            <label for="happy" class="col-sm-4 col-md-4 control-label text-right">Положение поля ввода</label>
            <div class="col-sm-7 col-md-7">
                <div class="input-group">
                    <div class="radioBtn btn-group">
                        <a class="btn btn-primary btn-sm {{ $inputUp[1] }}" data-toggle="input_up" data-title="1">В верху</a>
                        <a class="btn btn-primary btn-sm {{ $inputUp[0] }}" data-toggle="input_up" data-title="0">В низу</a>
                    </div>
                    <input type="hidden" name="input_up" id="input_up">
                </div>
            </div>
        </div>
        <br/><br/>
        <div class="form-group">
            <label for="happy" class="col-sm-4 col-md-4 control-label text-right">Первые сообщения</label>
            <div class="col-sm-7 col-md-7">
                <div class="input-group">
                    <div class="radioBtn btn-group">
                        <a class="btn btn-primary btn-sm {{ $firstUp[1] }}" data-toggle="first_up" data-title="1">В верху</a>
                        <a class="btn btn-primary btn-sm {{ $firstUp[0] }}" data-toggle="first_up" data-title="0">В низу</a>
                    </div>
                    <input type="hidden" name="first_up" id="first_up">
                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <div class="form-group ">
            <button type="submit" class="pull-right btn btn-success">Отправить</button>
        </div>
    </form>
    <div class="clearfix"></div><br/>
@endsection