@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}

<div class="form-group @if($errors->has('name'))has-error @endif">
    {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
    {{ Form::text('name', null, array('class' => 'form-control')) }}
    {{ $errors->first('name', '<p class="help-block">:message</p>') }}
</div>

<div class="form-group @if($errors->has('class'))has-error @endif">
    {{ Form::label('class', trans('validation.attributes.class'), array('class' => 'control-label')) }}
    {{ Form::text('class', null, array('class' => 'form-control')) }}
    {{ $errors->first('class', '<p class="help-block">:message</p>') }}
</div>

@include('admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        <div class="form-group">
            {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
            {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
        </div>
        <div class="checkbox">
            <label>
                {{ Form::checkbox($lang.'[status]', 1, $model->translate($lang)->status) }} @lang('validation.attributes.online')
            </label>
        </div>
    </div>

    @endforeach

</div>
