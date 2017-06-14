<tr>
    <td {{ $category->threadsEnabled ? '' : 'colspan=5' }}>
        <p class="{{ isset($titleClass) ? $titleClass : '' }}"><a href="{{ Forum::route('category.show', $category) }}">{{ $category->title }}</a></p>
        <span class="text-muted">{{ $category->description }}</span>
    </td>
    @if ($category->threadsEnabled)
        <td>{{ $category->thread_count }}</td>
        <td>{{ $category->post_count }}</td>
    @endif
</tr>
