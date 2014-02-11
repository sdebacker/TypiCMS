@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form', 'method' => 'post')) }}

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

		{{ Form::hidden('resetCode', $resetCode) }}

		{{ Form::hidden('id', $id) }}

		{{ Form::button(trans('validation.attributes.modify'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}

		{{ Form::close() }}

	</div>

</div>
@stop