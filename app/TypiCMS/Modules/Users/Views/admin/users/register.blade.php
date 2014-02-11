@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">

	<div id="register" class="container-login col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form')) }}

			<div class="form-group @if($errors->has('email'))has-error@endif">
				{{ Form::label('email', trans('validation.attributes.email')) }}
				{{ Form::text('email', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'email', 'autofocus' => 'autofocus')) }}
				@if($errors->has('email'))
				<span class="help-block">{{ $errors->first('email') }}</span>
				@endif
			</div>

			<div class="row">
				<div class="col-lg-6 form-group @if($errors->has('first_name'))has-error@endif">
					{{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
					{{ Form::text('first_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
					@if($errors->has('first_name'))
					<span class="help-block">{{ $errors->first('first_name') }}</span>
					@endif
				</div>
				<div class="col-lg-6 form-group @if($errors->has('last_name'))has-error@endif">
					{{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
					{{ Form::text('last_name', null, array('class' => 'form-control input-lg', 'required' => 'required')) }}
					@if($errors->has('last_name'))
					<span class="help-block">{{ $errors->first('last_name') }}</span>
					@endif
				</div>
			</div>

			<div class="form-group @if($errors->has('password'))has-error@endif">
				{{ Form::label('password', trans('validation.attributes.password'), array('class' => 'inpur-lg control-label')) }}
				{{ Form::password('password', array('class' => 'input-lg form-control', 'autocomplete' => 'off')) }}
				@if($errors->has('password'))
				<span class="help-block">{{ $errors->first('password') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('password_confirmation'))has-error@endif">
				{{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'inpur-lg control-label')) }}
				{{ Form::password('password_confirmation', array('class' => 'input-lg form-control', 'autocomplete' => 'off')) }}
				@if($errors->has('password_confirmation'))
				<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
				@endif
			</div>

			<div class="form-group">
				{{ Form::button(trans('validation.attributes.register'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}
			</div>

		{{ Form::close() }}

	</div>

</div>

@stop