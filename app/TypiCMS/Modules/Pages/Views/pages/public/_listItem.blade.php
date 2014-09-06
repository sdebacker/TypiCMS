<li id="page_{{ $child->id }}" class="{{ Request::is($child->uri) ? 'active' : '' }}">
    <a href="/{{ $child->uri }}">
        {{ $child->title }}
    </a>
    @if ($child->children)
        <ul>
            @foreach ($child->children as $childPage)
                @include('pages.public._listItem', array('child' => $childPage))
            @endforeach
        </ul>
    @endif
</li>
