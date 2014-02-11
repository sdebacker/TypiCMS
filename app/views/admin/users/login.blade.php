@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form')) }}

		<div class="form-group @if($errors->has('email'))has-error@endif">
			{{ Form::label('email', trans('validation.attributes.email'), array('class' => 'sr-only')) }}
			{{ Form::text('email', null, array('class' => 'form-control input-lg', 'placeholder' => trans('validation.attributes.email'), 'autofocus' => 'autofocus')) }}
			@if($errors->has('email'))
			<span class="help-block">{{ $errors->first('email') }}</span>
			@endif
		</div>
		<div class="form-group @if($errors->has('password'))has-error@endif">
			{{ Form::label('password', trans('validation.attributes.password'), array('class' => 'sr-only')) }}
			{{ Form::password('password', array('class' => 'form-control input-lg', 'placeholder' => trans('validation.attributes.password'))) }}
			@if($errors->has('password'))
			<span class="help-block">{{ $errors->first('password') }}</span>
			@endif
			<span class="help-block">{{ link_to_route('resetpassword', trans('modules.users.Forgot your password?')) }}</span>
		</div>
		<div class="form-group">
			{{ Form::button(trans('validation.attributes.log in'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
		</div>

		{{ Form::close() }}
		
	</div>

</div>

@stop