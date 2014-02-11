@section('main')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
	{{ Form::open(array( 'route' => array('admin.groups.store'))) }}
		<h2>Create New Group</h2>

		<div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
			{{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name')) }}
			{{ ($errors->has('name') ? $errors->first('name') : '') }}
		</div>

		{{ Form::label('Permissions') }}
		<div class="form-group">
			<label class="checkbox-inline">
				{{ Form::checkbox('adminPermissions', 1) }} Admin
			</label>
			<label class="checkbox-inline">
				{{ Form::checkbox('userPermissions', 1) }} User
			</label>

		</div>

		{{ Form::submit('Create New Group', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}
	</div>
</div>

@stop