<div class="row">

	<div class="form-group col-sm-12">
		<button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
		<a href="{{ route('admin.users.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
	</div>

	{{ Form::hidden('activated', 1); }}
	{{ Form::hidden('id'); }}

	<div class="col-sm-3">

		{{ Former::text('email')->required()->autofocus()->autocomplete('off'); }}

	</div>

	<div class="col-sm-3">
		@if(isset($user->id))
		{{ Former::password('password')->label('Change password (if not empty)')->autocomplete('off'); }}
		@else
		{{ Former::password('password')->required()->autocomplete('off'); }}
		{{ Former::password('password_confirmation')->required()->autocomplete('off'); }}
		@endif
	</div>

</div>

<div class="row">

	<div class="col-sm-3">

		{{ Form::text('first_name'); }}

	</div>

	<div class="col-sm-3">

		{{ Form::text('last_name'); }}

	</div>

</div>

<div class="row">

	<div class="col-sm-3">

	{{ Former::checkboxes('groups')->checkboxes($groups)->check($selectedGroups) }}

	</div>

</div>
