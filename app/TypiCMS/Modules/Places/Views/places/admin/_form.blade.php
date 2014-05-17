@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
    {{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language=fr')) }}
    {{ HTML::script(asset('js/gmaps.admin.js')) }}
@stop

<div class="row">

    @include('admin._buttons-form')

    {{ Form::hidden('id'); }}

    <div class="col-sm-6">

        <div class="form-group @if($errors->has('title'))has-error@endif">
            {{ Form::label('title', trans('validation.attributes.title')) }}
            {{ Form::text('title', null, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
            @if($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('slug'))has-error@endif">
            {{ Form::label('slug', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
            <div class="input-group">
                {{ Form::text('slug', null, array('class' => 'form-control')) }}
                <span class="input-group-btn">
                    <button class="btn btn-default btn-slug @if($errors->has('slug'))btn-danger@endif" type="button">@lang('validation.attributes.generate')</button>
                </span>
            </div>
            @if($errors->has('slug'))
            <span class="help-block">{{ $errors->first('slug') }}</span>
            @endif
        </div>

        <div class="row">

            @foreach ($locales as $lang)

            <fieldset class="col-sm-6" id="{{ $lang }}">
                <legend>{{ trans('global.languages.'.$lang) }}</legend>
                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[info]', trans('validation.attributes.info')) }}
                    {{ Form::textarea($lang.'[info]', $model->$lang->info, array('class' => 'form-control', 'rows' => 5)) }}
                </div>
            </fieldset>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">

        <div class="form-group">
            {{ Form::label('address', trans('validation.attributes.address'), array('class' => 'control-label')) }}
            {{ Form::text('address', null, array('class' => 'form-control')) }}
        </div>

        <div class="row">
            <div class="col-sm-6 form-group @if($errors->has('email'))has-error@endif">
                {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
                {{ Form::text('email', null, array('class' => 'form-control')) }}
                @if($errors->has('email'))
                <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="col-sm-6 form-group @if($errors->has('website'))has-error@endif">
                {{ Form::label('website', trans('validation.attributes.website'), array('class' => 'control-label')) }}
                {{ Form::text('website', null, array('class' => 'form-control')) }}
                @if($errors->has('website'))
                <span class="help-block">{{ $errors->first('website') }}</span>
                @endif
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

        @include('admin._image-fieldset')

    </div>

</div>
