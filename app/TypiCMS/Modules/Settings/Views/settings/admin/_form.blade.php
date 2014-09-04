@section('js')
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

<div class="row">
    <div class="form-group col-sm-12">
        <button class="btn-primary btn" type="submit">@lang('validation.attributes.save')</button>
    </div>
</div>

<label>@lang('validation.attributes.websiteTitle')</label>
@foreach ($locales as $lang)
    <div class="row">
        <div class="col-sm-9 form-group">
            <div class="input-group">
                <span class="input-group-addon">{{ strtoupper($lang) }}</span>
                {{ Form::text($lang.'[websiteTitle]', null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-sm-3 checkbox">
            <label>
                {{ Form::checkbox($lang.'[status]', 1) }} @lang('validation.attributes.online')
            </label>
        </div>
    </div>
@endforeach

<div class="form-group @if($errors->has('webmasterEmail'))has-error @endif">
    {{ Form::label('webmasterEmail', trans('validation.attributes.webmasterEmail'), array('class' => 'control-label')) }}
    {{ Form::text('webmasterEmail', null, array('class' => 'form-control')) }}
    {{ $errors->first('webmasterEmail', '<p class="help-block">:message</p>') }}
</div>
<div class="form-group @if($errors->has('welcomeMessageURL'))has-error @endif">
    {{ Form::label('welcomeMessageURL', trans('validation.attributes.welcomeMessageURL'), array('class' => 'control-label')) }}
    {{ Form::text('welcomeMessageURL', null, array('class' => 'form-control')) }}
    {{ $errors->first('welcomeMessageURL', '<p class="help-block">:message</p>') }}
</div>
<div class="form-group @if($errors->has('welcomeMessage'))has-error @endif">
    {{ Form::label('welcomeMessage', trans('validation.attributes.welcomeMessage'), array('class' => 'control-label')) }}
    {{ Form::textarea('welcomeMessage', null, array('class' => 'form-control', 'rows' => '3')) }}
    {{ $errors->first('welcomeMessage', '<p class="help-block">:message</p>') }}
</div>
<div class="form-group @if($errors->has('adminLocale'))has-error @endif">
    {{ Form::label('adminLocale', trans('validation.attributes.adminLocale'), array('class' => 'control-label')) }}
    {{ Form::select('adminLocale', array_combine($locales, $locales), null, array('class' => 'form-control')) }}
    {{ $errors->first('adminLocale', '<p class="help-block">:message</p>') }}
</div>
<div class="form-group @if($errors->has('typekitCode'))has-error @endif">
    {{ Form::label('typekitCode', trans('validation.attributes.typekitCode'), array('class' => 'control-label')) }}
    {{ Form::text('typekitCode', null, array('class' => 'form-control')) }}
    {{ $errors->first('typekitCode', '<p class="help-block">:message</p>') }}
</div>
<div class="form-group">
    {{ Form::label('googleAnalyticsCode', trans('validation.attributes.googleAnalyticsCode'), array('class' => 'control-label')) }}
    {{ Form::text('googleAnalyticsCode', null, array('class' => 'form-control')) }}
</div>
@if (Config::get('app.locale_in_url'))
<div class="checkbox">
    <label>
        {{ Form::checkbox('langChooser', 1) }} {{ trans('validation.attributes.langChooser') }}
    </label>
</div>
@endif
<div class="checkbox">
    <label>
        {{ Form::checkbox('authPublic', 1) }} {{ trans('validation.attributes.authPublic') }}
    </label>
</div>
<div class="checkbox">
    <label>
        {{ Form::checkbox('register', 1) }} {{ trans('validation.attributes.registration allowed') }}
    </label>
</div>
