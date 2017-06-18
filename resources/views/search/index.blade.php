@extends('layouts.app')

@section('content')
    <h2>Поиск по сайту:</h2>
    <form action="/search/result" method="get" class="form-horizontal">
        <div>
            <label for="query" class="label">
                Поиск:
            </label>
            <input type="text" class="form-control" name="q" />
        </div>
        <div>
            <button type="submit" class="btn btn-success">Искать</button>
        </div>
    </form>
@endsection
