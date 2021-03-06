<tr id="post-{{ $post->sequence }}" class="{{ $post->trashed() ? 'deleted' : '' }}" class="post-body">
    <td class="author-info">
        @if(UserHelper::getUserById($post->author_id)->isOnline())
            <span class="glyphicon glyphicon-user " style="color:green"></span>
        @else
            <span class="glyphicon glyphicon-user " style="color:red"></span>
        @endif
        <strong>{!! UserHelper::getLinkById($post->author_id) !!}</strong>
        <br />
        <img src="{{ UserHelper::getUserById($post->author_id)->avatar }}" height="100px" />
        <br/>
    </td>
    <td class="content">
        @if (!is_null($post->parent))
            <p>
                <strong>
                    {{ trans('forum::general.response_to', ['item' => $post->parent->authorName]) }}
                    (<a href="{{ Forum::route('post.show', $post->parent) }}">{{ trans('forum::posts.view') }}</a>):
                </strong>
            </p>
            <blockquote>
                {!! str_limit(Forum::render($post->parent->content)) !!}
            </blockquote>
        @endif

        @if ($post->trashed())
            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
        @else
            {!! strip_tags($post->content, '<br><a><img><blockquote><strike><b><p><i><code><p><h2><h3><h1><h4><ul><li><ol><pre>' ) !!}
        @endif
    </td>
</tr>
<tr class="post-footer">
    <td>
        @if (!$post->trashed())
            @can ('edit', $post)
                <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
            @endcan
        @endif
    </td>
    <td class="text-muted">
        {{ trans('forum::general.posted') }} {{ $post->posted }}
        @if ($post->hasBeenUpdated())
            | {{ trans('forum::general.last_updated') }} {{ $post->updated }}
        @endif
        <span class="pull-right">
            <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequence }}</a>
            @if (!$post->trashed())
                @can ('reply', $post->thread)
                    - <a href="{{ Forum::route('post.create', $post) }}">{{ trans('forum::general.reply') }}</a>
                @endcan
            @endif
            @if (Request::fullUrl() != Forum::route('post.show', $post))
                - <a href="{{ Forum::route('post.show', $post) }}">{{ trans('forum::posts.view') }}</a>
            @endif
            @if (isset($thread))
                @can ('deletePosts', $thread)
                    @if (!$post->isFirst)
                        <input type="checkbox" name="items[]" value="{{ $post->id }}">
                    @endif
                @endcan
            @endif
        </span>
    </td>
</tr>
