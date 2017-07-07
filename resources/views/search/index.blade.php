@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Поиск по сайту:</h2>
        <form action="/search/result" method="get" class="form-vertical">
            <div class="form-group">
                <label for="query" class="label">
                    Поиск:
                </label>
                <input type="text" class="form-control" name="q"/>
            </div>
            <div class="right">
                <button type="submit" class="btn btn-success">Искать</button>
            </div>
        </form>
    </div>
@endsection
