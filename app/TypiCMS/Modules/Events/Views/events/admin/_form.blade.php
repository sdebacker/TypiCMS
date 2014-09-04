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
    <div class="col-sm-4 form-group @if($errors->has('start_date'))has-error @endif">
        {{ Form::label('start_date', trans('validation.attributes.start_date'), array('class' => 'control-label')) }}
        {{ Form::text('start_date', $model->present()->dateOrNow('start_date', 'd.m.Y'), array('class' => 'datepicker form-control', 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
        {{ $errors->first('start_date', '<p class="help-block">:message</p>') }}
    </div>
    <div class="col-sm-3 form-group @if($errors->has('start_time'))has-error @endif">
        {{ Form::label('start_time', trans('validation.attributes.start_time'), array('class' => 'control-label')) }}
        {{ Form::text('start_time', null, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
        {{ $errors->first('start_time', '<p class="help-block">:message</p>') }}
    </div>
</div>

<div class="row">
    <div class="col-sm-4 form-group @if($errors->has('end_date'))has-error @endif">
        {{ Form::label('end_date', trans('validation.attributes.end_date'), array('class' => 'control-label')) }}
        {{ Form::text('end_date', $model->present()->dateOrNow('end_date', 'd.m.Y'), array('class' => 'datepicker form-control', 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
        {{ $errors->first('end_date', '<p class="help-block">:message</p>') }}
    </div>
    <div class="col-sm-3 form-group @if($errors->has('end_time'))has-error @endif">
        {{ Form::label('end_time', trans('validation.attributes.end_time'), array('class' => 'control-label')) }}
        {{ Form::text('end_time', null, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
        {{ $errors->first('end_time', '<p class="help-block">:message</p>') }}
    </div>
</div>

@include('admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        <div class="row">
            <div class="col-md-6 form-group">
                {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
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
            {{ Form::label($lang.'[summary]', trans('validation.attributes.summary')) }}
            {{ Form::textarea($lang.'[summary]', $model->translate($lang)->summary, array('class' => 'form-control', 'rows' => 4)) }}
        </div>
        <div class="form-group">
            {{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
            {{ Form::textarea($lang.'[body]', $model->translate($lang)->body, array('class' => 'editor form-control')) }}
        </div>
    </div>

    @endforeach

</div>
