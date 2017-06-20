<div class="panel panel-info">
    <div class="panel-heading">
        {{ strip_tags($notify['data']['title']) }}
    </div>
    <div class="panel-body">
        {{ strip_tags($notify['data']['message']) }}
    </div>
    <div class="panel-footer">
        {{ $notify['created_at'] }}
        | <a href="/notifi/read/{{ $notify['id'] }}">Читать</a>
        | <a href="/notifi/asread/{{ $notify['id'] }}">Отметить как прочитанное</a>
    </div>
</div>