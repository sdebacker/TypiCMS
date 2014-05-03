<li id="item_{{ $model->id }}">
    <div>
        {{ $model->present()->checkbox }}
        {{ $model->present()->edit }}
        {{ $model->present()->status }}
        {{ $model->title }}
        <div class="attachments">{{ $model->present()->countFiles }}</div>
    </div>
    @if ($model->children)
        <ul>
            @foreach ($model->children as $submodel)
                @include('pages.admin._listItem', array('model' => $submodel))
            @endforeach
        </ul>
    @endif
</li>
