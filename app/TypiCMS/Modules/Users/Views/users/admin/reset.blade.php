@section('page-header')
@stop
@section('sidebar')
@stop
@section('mainClass')
@stop

@section('main')

<div id="reset" class="container-reset container-xs-center">

    {{ Form::open(array('role' => 'form', 'method' => 'post')) }}

        <h1>@lang('users::global.Reset password')</h1>

        <div class="form-group @if($errors->has('email'))has-error @endif">
            {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'sr-only')) }}
            {{ Form::email('email', null, array('class' => 'form-control input-lg', 'placeholder' => trans('validation.attributes.email'), 'autofocus' => 'autofocus')) }}
            @if($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group form-action">
            {{ Form::button(trans('validation.attributes.reset password'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
        </div>

    {{ Form::close() }}

</div>

@stop
