@section('page-header')
@stop
@section('sidebar')
@stop
@section('mainClass')
@stop

@section('main')

<div id="login" class="container-newpassword container-xs-center">

    {{ Form::open(array('role' => 'form', 'method' => 'post')) }}

    <h1>@lang('users::global.New password')</h1>

    <div class="form-group @if($errors->has('password'))has-error @endif">
        {{ Form::label('password', trans('validation.attributes.password'), array('class' => 'control-label')) }}
        {{ Form::password('password', array('class' => 'input-lg form-control', 'autofocus', 'autocomplete' => 'off')) }}
        @if($errors->has('password'))
        <span class="help-block">{{ $errors->first('password') }}</span>
        @endif
    </div>

    <div class="form-group @if($errors->has('password_confirmation'))has-error @endif">
        {{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'control-label')) }}
        {{ Form::password('password_confirmation', array('class' => 'input-lg form-control', 'autocomplete' => 'off')) }}
        @if($errors->has('password_confirmation'))
        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>

    {{ Form::hidden('resetCode', $resetCode) }}
    {{ Form::hidden('id', $id) }}

    <div class="form-group form-action">
        {{ Form::button(trans('validation.attributes.modify'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
    </div>

    {{ Form::close() }}

</div>

@stop
