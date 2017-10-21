<div class="panel panel-info">
    <div class="panel-heading">
        {{ strip_tags($notify['data']['title']) }}
    </div>
    <div class="panel-body">
        {{ strip_tags($notify['data']['message'], '<br><a><img><blockquote><strike><b><p><i><code><p><h2><h3><h1><h4><ul><li><ol><pre>') }}
    </div>
    <div class="panel-footer">
        {{ $notify['created_at'] }}
        | <a href="/notifi/read/{{ $notify['id'] }}">Читать</a>
        | <a href="/notifi/asread/{{ $notify['id'] }}">Отметить как прочитанное</a>
    </div>
</div>