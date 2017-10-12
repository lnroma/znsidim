@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Список игр денди</div>
        <div class="panel-body">
            @can('superadmin')
                <a href="/games/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Добавить
                    игру!</a>
            @endcan
            <table class="table table-bordered">
                @foreach($games as $_game)
                    <tr>
                        <td width="20%">
                            <a href="/games/show/{{$_game->id}}">
                                {{ $_game->name }}
                            </a>
                        </td>
                        <td width="80%">
                            {{ $_game->short_description }}
                        </td>
                    </tr>
                    @endforeach
            </table>
            {{$games->render()}}
        </div>
    </div>
@endsection