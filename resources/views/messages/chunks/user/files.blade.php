<table class="table table-striped">
    <thead>
    <tr>
        <th>Имя файла</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($files as $_file): ?>
    <tr>
        <td><img src="{{$_file['url']}}" height="50px"/></td>
        <td>
            <div class="btn-group pull-right">
                <a ng-click="remove('{{$_file['url']}}', '{{$id_editor}}')" class="btn btn-primary">Удалить</a>
                <a ng-click="send('{{$_file['url']}}', '{{$id_editor}}')" class="btn btn-primary">Отправить</a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
