<li id="page_{{ $model->id }}" class="{{ $model->activeClass() }}">
    <a href="/{{ $model->uri }}">
        {{ $model->title }}
    </a>
    @if ($model->children)
        <ul>
            @foreach ($model->children as $submodel)
                @include('pages.public._listItem', array('model' => $submodel))
            @endforeach
        </ul>
    @endif
</li>
