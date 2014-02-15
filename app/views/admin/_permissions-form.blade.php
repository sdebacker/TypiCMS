<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th></th>
				<th><input type="checkbox" id="view-all"> @lang('global.crud.View')</th>
				<th><input type="checkbox" id="create-all"> @lang('global.crud.Create')</th>
				<th><input type="checkbox" id="edit-all"> @lang('global.crud.Update')</th>
				<th><input type="checkbox" id="delete-all"> @lang('global.crud.Delete')</th>
			</tr>
		</thead>
		<tbody>
		@foreach (Config::get('app.modules') as $module => $infos)
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.view]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.create]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.edit]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.delete]">
			<tr>
				<td>{{ $module }}</td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.view']) and $permissions['admin.'.strtolower($module).'.view'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.view]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.create']) and $permissions['admin.'.strtolower($module).'.create'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.create]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.edit']) and $permissions['admin.'.strtolower($module).'.edit'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.edit]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.delete']) and $permissions['admin.'.strtolower($module).'.delete'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.delete]"></td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
