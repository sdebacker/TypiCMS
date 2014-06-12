@section('js')
    {{ HTML::script('js/admin/checkboxes-permissions.js') }}
@stop

{{ Form::hidden('id') }}

@include('admin._buttons-form')

<div class="row">

    <div class="col-sm-6">

        <div class=" form-group @if($errors->has('name'))has-error @endif">
            {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            @if($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
            @endif
        </div>

    </div>

</div>

<label>@lang('groups::global.Group permissions')</label>
@include('admin._permissions-form')
