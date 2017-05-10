@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Список чатов sidimvprobke.com</div>

                    <div class="panel-body">
                        <h2>Список чатов</h2>
                        <p>Чаты доступные для общения</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Название чата</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
