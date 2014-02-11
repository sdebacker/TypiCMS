@section('main')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
	{{ Form::model( $group, array( 'route' => array('admin.groups.update', $group->id), 'method' => 'patch', 'role' => 'form' ) ) }}
		<h2>Edit Group</h2>
		<div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
			{{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => 'Name')) }}
			{{ ($errors->has('name') ? $errors->first('name') : '') }}
		</div>

		{{ Form::label('Permissions') }}
		<?php 
			$permissions = $group->getPermissions(); 
			if (!array_key_exists('admin', $permissions)) $permissions['admin'] = 0;
			if (!array_key_exists('users', $permissions)) $permissions['users'] = 0;
		?>
		
		<div class="form-group">
			<label class="checkbox-inline">
				{{ Form::checkbox('adminPermissions', 1, $permissions['admin'] ) }} Admin
			</label>
			<label class="checkbox-inline">
				{{ Form::checkbox('userPermissions', 1, $permissions['users'] ) }} Users
			</label>
		</div>

		{{ Form::hidden('id', $group->id) }}
		{{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
	</div>
</div>
@stop