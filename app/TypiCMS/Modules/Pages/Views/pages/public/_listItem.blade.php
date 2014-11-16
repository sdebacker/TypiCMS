<li id="page_{{ $child->id }}" class="{{ Request::is($child->uri) ? 'active' : '' }}">
    <a href="/{{ $child->uri }}">
        {{ $child->title }}
    </a>
    @if ($child->items)
        <ul>
            @foreach ($child->items as $childPage)
                @include('pages.public._listItem', array('child' => $childPage))
            @endforeach
        </ul>
    @endif
</li>
