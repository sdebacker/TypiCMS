@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}

<div class="form-group @if($errors->has('name'))has-error @endif">
    {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
    {{ Form::text('name', null, array('class' => 'form-control', 'autofocus')) }}
    {{ $errors->first('name', '<p class="help-block">:message</p>') }}
</div>

@include('admin._tabs-lang-form', ['target' => 'content'])

<div class="tab-content">

@foreach ($locales as $lang)

    <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
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
