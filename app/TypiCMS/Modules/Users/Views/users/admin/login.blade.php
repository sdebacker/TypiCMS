@section('page-header')
@stop
@section('sidebar')
@stop
@section('mainClass')
@stop

@section('main')

<div id="login" class="container-login container-xs-center">

    {{ Form::open(array('role' => 'form')) }}

    <h1>@lang('users::global.Log in')</h1>

    <div class="form-group @if($errors->has('email'))has-error @endif">
        {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'sr-only')) }}
        {{ Form::email('email', null, array('class' => 'form-control input-lg', 'autofocus', 'placeholder' => trans('validation.attributes.email'))) }}
        @if($errors->has('email'))
        <span class="help-block">{{ $errors->first('email') }}</span>
        @endif
    </div>

    <div class="form-group @if($errors->has('password'))has-error @endif">
        {{ Form::label('password', trans('validation.attributes.password'), array('class' => 'sr-only')) }}
        {{ Form::password('password', array('class' => 'form-control input-lg', 'placeholder' => trans('validation.attributes.password'))) }}
        @if($errors->has('password'))
        <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
    </div>

    <div class="form-group">
        <span class="help-block">{{ link_to_route('resetpassword', trans('users::global.Forgot your password?')) }}</span>
    </div>

    <div class="form-group">
        {{ Form::button(trans('validation.attributes.log in'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
    </div>

    {{ Form::close() }}

</div>

@stop
