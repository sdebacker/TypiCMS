<li id="page_{{ $child->id }}" class="{{ Request::is($child->uri) ? 'active' : '' }}">
    <a href="/{{ $child->uri }}">
        {{ $child->title }}
    </a>
    @if ($child->models)
        <ul>
            @foreach ($child->models as $childPage)
                @include('pages.public._listItem', array('child' => $childPage))
            @endforeach
        </ul>
    @endif
</li>
