@section('page-header')
@stop
@section('sidebar')
@stop
@section('mainClass')
@stop

@section('main')

<div id="register" class="container-register container-xs-center">

    {{ Form::open(array('role' => 'form')) }}

        <h1>@lang('users::global.Register')</h1>

        <div class="form-group @if($errors->has('email'))has-error @endif">
            {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
            {{ Form::email('email', null, array('class' => 'form-control input-lg', 'required' => 'required', 'autofocus')) }}
            @if($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('first_name'))has-error @endif">
            {{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
            {{ Form::text('first_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
            @if($errors->has('first_name'))
            <span class="help-block">{{ $errors->first('first_name') }}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('last_name'))has-error @endif">
            {{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
            {{ Form::text('last_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
            @if($errors->has('last_name'))
            <span class="help-block">{{ $errors->first('last_name') }}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('password'))has-error @endif">
            {{ Form::label('password', trans('validation.attributes.password'), array('class' => 'control-label')) }}
            {{ Form::password('password', array('class' => 'form-control input-lg', 'autocomplete' => 'off')) }}
            @if($errors->has('password'))
            <span class="help-block">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="form-group @if($errors->has('password_confirmation'))has-error @endif">
            {{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'control-label')) }}
            {{ Form::password('password_confirmation', array('class' => 'form-control input-lg', 'autocomplete' => 'off')) }}
            @if($errors->has('password_confirmation'))
            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="form-group form-action">
            {{ Form::button(trans('validation.attributes.register'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
        </div>

    {{ Form::close() }}

</div>

@stop
