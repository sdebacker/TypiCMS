@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('main')

<h4>Available Groups</h4>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<th>Name</th>
				<th>Permissions</th>
				<th>Options</th>
			</thead>
			<tbody>
			@foreach ($groups as $group)
				<tr>
					<td><a href="groups/{{ $group->id }}">{{ $group->name }}</a></td>
					<td>{{ (isset($group['permissions']['admin'])) ? '<i class="icon-ok"></i> Admin' : ''}} {{ (isset($group['permissions']['users'])) ? '<i class="icon-ok"></i> Users' : ''}}</td>
					<td>
						<button class="btn btn-default" onClick="location.href='{{ route('admin.groups.edit', array($group->id)) }}'">Edit</button>
					 	<button class="btn btn-default action_confirm {{ ($group->id == 2) ? 'disabled' : '' }}" type="button" data-method="delete" href="{{ URL::to('groups') }}/{{ $group->id }}">Delete</button>
					 </td>
				</tr>	
			@endforeach
			</tbody>
		</table> 
	</div>
	<button class="btn btn-primary" onClick="location.href='{{ route('admin.groups.create') }}'">New Group</button>
	</div>
</div>

@stop

