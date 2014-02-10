@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form')) }}

		<div class="form-group">
			{{ Form::label('email', trans('validation.attributes.email'), array('class' => 'sr-only')) }}
			{{ Form::text('email', null, array('class' => 'form-control input-lg', 'placeholder' => 'email', 'autofocus' => 'autofocus')) }}
		</div>
		<div class="form-group">
			{{ Form::label('password', trans('validation.attributes.password'), array('class' => 'sr-only')) }}
			{{ Form::password('password', array('class' => 'form-control input-lg', 'placeholder' => 'password')) }}
			<span class="help-block">{{ link_to_route('resetpassword', trans('modules.users.Forgot your password?')) }}</span>
		</div>
		<div class="form-group">
			{{ Form::button(trans('validation.attributes.log in'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
		</div>

		{{ Form::close() }}
		
	</div>

</div>

@stop