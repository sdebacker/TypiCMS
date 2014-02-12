{{ Form::hidden('id') }}

<div class="row">

	<div class="form-group col-sm-12">
		<button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
		<a href="{{ route('admin.groups.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
	</div>

	<div class="col-sm-3">

		<div class=" form-group @if($errors->has('name'))has-error@endif">
			{{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
			{{ Form::text('name', null, array('class' => 'form-control')) }}
			@if($errors->has('name'))
			<span class="help-block">{{ $errors->first('name') }}</span>
			@endif
		</div>

		<div class="form-group @if($errors->has('name'))has-error@endif">
			{{ Form::label('permissions', trans('validation.attributes.permissions'), array('class' => 'control-label')) }}
<?php
			$permissions = array('admin' => 0, 'users' => 0);
			if (isset($group)) {
				$permissions = $group->getPermissions();
				if ( ! array_key_exists('admin', $permissions)) $permissions['admin'] = 0;
				if ( ! array_key_exists('users', $permissions)) $permissions['users'] = 0;
			}  ?>
			<div class="form-group">
				<label class="checkbox-inline">
					{{ Form::checkbox('adminPermissions', 1, $permissions['admin'] ) }} Admin
				</label>
				<label class="checkbox-inline">
					{{ Form::checkbox('userPermissions', 1, $permissions['users'] ) }} Users
				</label>
			</div>
		</div>

	</div>

</div>