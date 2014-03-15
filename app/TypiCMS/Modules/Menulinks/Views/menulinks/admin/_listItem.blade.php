<li id="item_{{ $model->id }}">
    <div>
        {{ $model->checkbox }}
        {{ $model->edit }}
        {{ $model->status }}
        {{ $model->title }}
    </div>
    @if ($model->children)
        <ul>
            @foreach ($model->children as $submodel)
                @include('menulinks.admin._listItem', array('model' => $submodel))
            @endforeach
        </ul>
    @endif
</li>
