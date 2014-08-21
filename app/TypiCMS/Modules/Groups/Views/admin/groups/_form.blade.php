@section('js')
    {{ HTML::script('js/admin/checkboxes-permissions.js') }}
@stop

{{ Form::hidden('id') }}

@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

<div class="row">

    <div class="col-sm-6">

        <div class=" form-group @if($errors->has('name'))has-error @endif">
            {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            {{ $errors->first('name', '<p class="help-block">:message</p>') }}
        </div>

    </div>

</div>

<label>@lang('groups::global.Group permissions')</label>
@include('admin._permissions-form')
