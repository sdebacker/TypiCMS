@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('titleLeftButton')
    <a id="uploaderAddButtonContainer" href="{{ route('admin.files.create') }}"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        {{ Form::open(array('route' => 'admin.files.store', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}

            {{ Form::hidden('gallery_id', Input::get('gallery_id', 0)) }}
            @foreach (Config::get('app.locales') as $locale)
                {{ Form::hidden($locale.'[description]') }}
                {{ Form::hidden($locale.'[alt_attribute]', '') }}
                {{ Form::hidden($locale.'[keywords]') }}
            @endforeach

            <div class="dropzone-previews"></div>
            <div class="dz-message">@lang('files::global.Drop files to upload')</div>

        {{ Form::close() }}
        <div class="table-responsive">

            <table class="table table-condensed table-main">

                <thead>

                    <tr>
                        {{ Html::th('checkboxes', null, false, false) }}
                        {{ Html::th('edit', null, false, false) }}
                        {{ Html::th('position', 'asc') }}
                        {{ Html::th('preview', null, false) }}
                        {{ Html::th('filename') }}
                        {{ Html::th('alt_attribute', null, false) }}
                        {{ Html::th('size (px)', null, false) }}
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $key => $model)
                    <tr>
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->present()->edit }}</td>
                        <td>{{ $model->position }}</td>
                        <td>{{ $model->present()->thumb(null, 22) }}</td>
                        <td>{{ $model->filename }}</td>
                        <td>{{ $model->alt_attribute }}</td>
                        <td>{{ $model->width }} × {{ $model->height }}</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
