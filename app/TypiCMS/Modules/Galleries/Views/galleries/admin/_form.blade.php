@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('admin._navbar-public-link')
@stop

@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}

<div class="row">

    <div class="col-sm-6">

        <div class="form-group @if($errors->has('name'))has-error @endif">
            {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
            {{ Form::text('name', null, array('autofocus', 'class' => 'form-control')) }}
            {{ $errors->first('name', '<p class="help-block">:message</p>') }}
        </div>


        @include('admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                    {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('class' => 'form-control')) }}
                </div>
                <div class="form-group @if($errors->has($lang.'.slug'))has-error @endif">
                    {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                        </span>
                    </div>
                    {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox($lang.'[status]', 1, $model->translate($lang)->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
                    {{ Form::textarea($lang.'[body]', $model->translate($lang)->body, array('class' => 'editor form-control')) }}
                </div>
            </div>

            @endforeach

        </div>

    </div>

    @if ($model->id)
        <iframe class="col-sm-6" height="1000" src="/admin/files?view=gallery&amp;gallery_id={{ $model->id }}" frameborder="0"></iframe>
    @else
        <div class="col-sm-6">
            <p class="alert alert-info">Create the gallery, then add files</p>
        </div>
    @endif

</div>
