@section('head')
	{{ HTML::script('js/checkboxes-permissions.js') }}
@stop

{{ Form::hidden('id') }}

<div class="row">

	<div class="form-group col-sm-12">
		<button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
		<a href="{{ route('admin.groups.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
	</div>

</div>

<div class="row">

	<div class="col-sm-6">

		<div class=" form-group @if($errors->has('name'))has-error@endif">
			{{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
			{{ Form::text('name', null, array('class' => 'form-control')) }}
			@if($errors->has('name'))
			<span class="help-block">{{ $errors->first('name') }}</span>
			@endif
		</div>

	</div>

</div>

<label>@lang('modules.groups.Group permissions')</label>
@include('admin._permissions-form')
