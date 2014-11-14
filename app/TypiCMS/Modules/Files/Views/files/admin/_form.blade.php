@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop


@include('admin._buttons-form')

<div class="row">

    {{ Form::hidden('id'); }}

    <div class="col-sm-6">

        @include('admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[alt_attribute]', trans('validation.attributes.alt_attribute')) }}
                    {{ Form::text($lang.'[alt_attribute]', $model->translate($lang)->alt_attribute, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[description]', trans('validation.attributes.description')) }}
                    {{ Form::textarea($lang.'[description]', $model->translate($lang)->description, array('class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[keywords]', trans('validation.attributes.keywords')) }}
                    {{ Form::text($lang.'[keywords]', $model->translate($lang)->keywords, array('class' => 'form-control')) }}
                </div>
            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">

        {{ Form::hidden('folder_id', $model->folder_id ?: 0) }}
        {{ Form::hidden('gallery_id', $model->gallery_id ?: 0) }}
        {{ Form::hidden('user_id', $model->user_id ?: 0) }}
        {{ Form::hidden('type') }}
        {{ Form::hidden('position', $model->position ?: 0) }}
        {{ Form::hidden('path') }}
        {{ Form::hidden('filename') }}
        {{ Form::hidden('extension') }}
        {{ Form::hidden('mimetype') }}
        {{ Form::hidden('width') }}
        {{ Form::hidden('height') }}
        {{ Form::hidden('download_count', $model->download_count ?: 0) }}

        @include('admin._image-fieldset', ['field' => 'filename'])

        <table class="table table-condensed">
            <thead>
                <th>{{ trans('validation.attributes.file information') }}</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <th>{{ trans('validation.attributes.path') }}</th>
                    <td>{{ $model->path }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.filename') }}</th>
                    <td>{{ $model->filename }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.extension') }}</th>
                    <td>{{ $model->extension }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.mimetype') }}</th>
                    <td>{{ $model->mimetype }}</td>
                </tr>
                @if ($model->width)
                <tr>
                    <th>{{ trans('validation.attributes.width') }}</th>
                    <td>{{ $model->width }} px</td>
                </tr>
                @endif
                @if ($model->height)
                <tr>
                    <th>{{ trans('validation.attributes.height') }}</th>
                    <td>{{ $model->height }} px</td>
                </tr>
                @endif
                <!-- <tr>
                    <th>{{ trans('validation.attributes.user_id') }}</th>
                    <td>{{ $model->user_id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.name') }}</th>
                    <td>{{ $model->name }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.folder_id') }}</th>
                    <td>{{ $model->folder_id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.user_id') }}</th>
                    <td>{{ $model->user_id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.type') }}</th>
                    <td>{{ $model->type }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.position') }}</th>
                    <td>{{ $model->position }}</td>
                </tr> -->
            </tbody>
        </table>

    </div>

</div>
