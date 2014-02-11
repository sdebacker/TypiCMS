@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">

	<div id="register" class="container-login col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form')) }}

			<div class="form-group">
				{{ Form::label('email', trans('validation.attributes.email')) }}
				{{ Form::text('email', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'email', 'autofocus' => 'autofocus')) }}
			</div>

			<div class="row">
				<div class="col-lg-6 form-group">
					{{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
					{{ Form::text('first_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
				</div>
				<div class="col-lg-6 form-group">
					{{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
					{{ Form::text('last_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 form-group">
					{{ Form::label('password', trans('validation.attributes.password')) }}
					{{ Form::password('password', array('class' => 'form-control input-lg', 'autocomplete' => 'off', 'required' => 'required')) }}
				</div>
				<div class="col-lg-6 form-group">
					{{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation')) }}
					{{ Form::password('password_confirmation', array('class' => 'form-control input-lg', 'autocomplete' => 'off', 'required' => 'required')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::button(trans('validation.attributes.register'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
			</div>

		{{ Form::close() }}

	</div>

</div>

@stop