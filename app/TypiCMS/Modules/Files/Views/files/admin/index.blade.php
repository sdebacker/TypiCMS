@section('js')
    {{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('addButton')
    <a id="uploaderAddButtonContainer" href="{{ route('admin.pages.files.create', $parent->id) }}"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        {{ Form::open(array('route' => array('admin.' . $parent->route . '.files.store', $parent->id), 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}
            @foreach (Config::get('app.locales') as $locale)
                {{ Form::hidden($locale.'[status]', 1) }}
                {{ Form::hidden($locale.'[description]') }}
                {{ Form::hidden($locale.'[alt_attribute]', '') }}
                {{ Form::hidden($locale.'[keywords]') }}
            @endforeach
            {{ Form::hidden('fileable_id', $parent->id); }}
            {{ Form::hidden('fileable_type', get_class($parent)); }}

            <div class="dropzone-previews clearfix sortable sortable-thumbnails">
            @foreach ($models as $key => $model)
                <a class="thumbnail" id="item_{{ $model->id }}" href="{{ route('admin.' . $parent->route . '.files.edit', array($model->fileable_id, $model->id)) }}">
                    {{ $model->present()->checkbox }}
                    {{ $model->present()->thumb }}
                    <div class="caption">
                        <small>{{ $model->present()->status }} {{ $model->filename }}</small>
                        <div>{{ $model->alt_attribute }}</div>
                    </div>
                </a>
            @endforeach
            </div>
            <div class="dz-message">@lang('files::global.Drop files to upload')</div>

        {{ Form::close() }}

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
