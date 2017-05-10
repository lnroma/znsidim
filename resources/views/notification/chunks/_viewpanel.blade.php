<div class="panel panel-info">
    <div class="panel-heading">
        {{ $notify['data']['title'] }}
    </div>
    <div class="panel-body">
        {{ $notify['data']['message'] }}
    </div>
    <div class="panel-footer">
        {{ $notify['created_at'] }} | <a href="{{ $notify['data']['link'] }}">Читать</a>
    </div>
</div>