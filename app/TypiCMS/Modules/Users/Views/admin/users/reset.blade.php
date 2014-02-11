@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
	@parent
</div>
@stop

@section('main')

<div class="row">
	
	<div id="reset" class="container-reset col-sm-4 col-sm-offset-4">

		{{ Form::open(array('role' => 'form', 'method' => 'post')) }}

			<div class="form-group @if($errors->has('email'))has-error@endif">
				{{ Form::label('email', trans('validation.attributes.email'), array('class' => 'sr-only')) }}
				{{ Form::text('email', null, array('class' => 'form-control input-lg', 'placeholder' => trans('validation.attributes.email'), 'autofocus' => 'autofocus')) }}
				@if($errors->has('email'))
				<span class="help-block">{{ $errors->first('email') }}</span>
				@endif
			</div>

			{{ Form::button(trans('validation.attributes.reset password'), array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit')) }}

		{{ Form::close() }}
		
	</div>

</div>


@stop