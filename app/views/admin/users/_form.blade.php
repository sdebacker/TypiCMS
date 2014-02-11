<div class="row">

	<div class="form-group col-sm-12">
		<button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
		<a href="{{ route('admin.users.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
	</div>

	{{ Form::hidden('activated', 1) }}
	{{ Form::hidden('id') }}

	<div class="col-sm-3">
		<div class="form-group @if($errors->has('email'))has-error@endif">
			{{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label', 'autocomplete' => 'off')) }}
			{{ Form::text('email', null, array('class' => 'form-control')) }}
			@if($errors->has('email'))
			<span class="help-block">{{ $errors->first('email') }}</span>
			@endif
		</div>
	</div>

	<div class="col-sm-3">
		@if(isset($model->id))
			<div class="form-group @if($errors->has('password'))has-error@endif">
				{{ Form::label('password', trans('Change password (if not empty)'), array('class' => 'control-label')) }}
				{{ Form::password('password', array('class' => 'form-control', 'autocomplete' => 'off')) }}
				@if($errors->has('password'))
				<span class="help-block">{{ $errors->first('password') }}</span>
				@endif
			</div>
		@else
			<div class="form-group @if($errors->has('password'))has-error@endif">
				{{ Form::label('password', trans('validation.attributes.password'), array('class' => 'control-label')) }}
				{{ Form::password('password', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
				@if($errors->has('password'))
				<span class="help-block">{{ $errors->first('password') }}</span>
				@endif
			</div>
			<div class="form-group @if($errors->has('password_confirmation'))has-error@endif">
				{{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'control-label')) }}
				{{ Form::password('password_confirmation', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
				@if($errors->has('password_confirmation'))
				<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
				@endif
			</div>
		@endif
	</div>

</div>

<div class="row">

	<div class="col-sm-3">

		<div class="form-group @if($errors->has('first_name'))has-error@endif">
			{{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
			{{ Form::text('first_name', null, array('class' => 'form-control')); }}
			@if($errors->has('first_name'))
			<span class="help-block">{{ $errors->first('first_name') }}</span>
			@endif
		</div>

	</div>

	<div class="col-sm-3">

		<div class="form-group @if($errors->has('last_name'))has-error@endif">
			{{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
			{{ Form::text('last_name', null, array('class' => 'form-control')); }}
			@if($errors->has('last_name'))
			<span class="help-block">{{ $errors->first('last_name') }}</span>
			@endif
		</div>

	</div>

</div>

<div class="row">

	<div class="col-sm-3">

		<div class="form-group">
		<label>@lang('validation.attributes.groups')</label>
		@foreach($groups as $groupName => $groupValue)
			<label class="checkbox">
				{{ Form::checkbox($groupValue, 1, $selectedGroups[$groupValue]) }} {{ $groupName }}
			</label>
		@endforeach
		</div>

	</div>

</div>
