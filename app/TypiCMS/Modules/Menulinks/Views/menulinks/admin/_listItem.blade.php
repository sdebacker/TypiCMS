<li id="item_{{ $model->id }}">
    <div>
        {{ $model->present()->checkbox }}
        {{ $model->present()->edit }}
        {{ $model->present()->status }}
        {{ $model->title }}
    </div>
    @if ($model->models)
        <ul>
            @foreach ($model->models as $submodel)
                @include('menulinks.admin._listItem', array('model' => $submodel))
            @endforeach
        </ul>
    @endif
</li>
