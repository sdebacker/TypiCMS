@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
    {{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language=fr')) }}
    {{ HTML::script(asset('js/admin/gmaps.js')) }}
@stop

@section('otherSideLink')
    @include('admin._navbar-public-link')
@stop


@include('admin._buttons-form')

{{ Form::hidden('id') }}

@include('admin._image-fieldset', ['field' => 'image'])

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-info" data-target="#tab-info" data-toggle="tab">@lang('global.Info')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        @include('admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
                <div class="row">
                    <div class="col-md-6 form-group">
                        {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                        {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('class' => 'form-control')) }}
                    </div>
                    <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                        {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                        <div class="input-group">
                            {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                            </span>
                        </div>
                        {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                    </div>
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

    {{-- Info tab --}}
    <div class="tab-pane fade in" id="tab-info">

        <div class="form-group">
            {{ Form::label('address', trans('validation.attributes.address'), array('class' => 'control-label')) }}
            {{ Form::text('address', null, array('class' => 'form-control')) }}
        </div>

        <div class="row">
            <div class="col-sm-6 form-group @if($errors->has('email'))has-error @endif">
                {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
                {{ Form::text('email', null, array('class' => 'form-control')) }}
                {{ $errors->first('email', '<p class="help-block">:message</p>') }}
            </div>
            <div class="col-sm-6 form-group @if($errors->has('website'))has-error @endif">
                {{ Form::label('website', trans('validation.attributes.website'), array('class' => 'control-label')) }}
                {{ Form::text('website', null, array('class' => 'form-control')) }}
                {{ $errors->first('website', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group">
                {{ Form::label('phone', trans('validation.attributes.phone'), array('class' => 'control-label')) }}
                {{ Form::text('phone', null, array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-6 form-group">
                {{ Form::label('fax', trans('validation.attributes.fax'), array('class' => 'control-label')) }}
                {{ Form::text('fax', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group">
                {{ Form::label('latitude', trans('validation.attributes.latitude'), array('class' => 'control-label')) }}
                {{ Form::text('latitude', null, array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-6 form-group">
                {{ Form::label('longitude', trans('validation.attributes.longitude'), array('class' => 'control-label')) }}
                {{ Form::text('longitude', null, array('class' => 'form-control')) }}
            </div>
        </div>

    </div>

</div>
