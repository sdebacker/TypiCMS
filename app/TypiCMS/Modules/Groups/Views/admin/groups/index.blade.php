@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($groups) }}</span> @choice('modules.groups.groups', count($groups))
@stop

@section('addButton')
	<a href="{{ route('admin.groups.create') }}" class=""><span class="glyphicon glyphicon glyphicon-plus-sign"></span><span class="sr-only">{{ ucfirst(trans('modules.users.New')) }}</span></a>&nbsp;
@stop

@section('main')

<table class="table table-striped table-hover">
	<thead>
		<th>Options</th>
		<th>Name</th>
		<th>Permissions</th>
	</thead>
	<tbody>
	@foreach ($groups as $group)
		<tr>
			<td>
				<button class="btn btn-xs btn-danger action_confirm {{ ($group->id == 1) ? 'disabled' : '' }}" type="button" data-method="delete" href="{{ URL::to('groups') }}/{{ $group->id }}">Delete</button>
			</td>
			<td><a href="{{ route('admin.groups.edit', array($group->id)) }}">{{ $group->name }}</a></td>
			<td>{{ implode(', ', array_keys($group['permissions'])) }}</td>
		</tr>	
	@endforeach
	</tbody>
</table> 

@stop

