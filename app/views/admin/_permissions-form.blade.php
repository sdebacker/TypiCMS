<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th></th>
				<th><input type="checkbox" id="view-all"> @lang('global.crud.Index')</th>
				<th><input type="checkbox" id="view-all"> @lang('global.crud.View')</th>
				<th><input type="checkbox" id="create-all"> @lang('global.crud.Create')</th>
				<th><input type="checkbox" id="create-all"> @lang('global.crud.Store')</th>
				<th><input type="checkbox" id="edit-all"> @lang('global.crud.Update')</th>
				<th><input type="checkbox" id="edit-all"> @lang('global.crud.Sort')</th>
				<th><input type="checkbox" id="destroy-all"> @lang('global.crud.Delete')</th>
			</tr>
		</thead>
		<tbody>
		@foreach (Config::get('app.modules') as $module => $infos)
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.index]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.view]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.create]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.store]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.edit]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.sort]">
			<input type="hidden" value="0" name="permissions[admin.{{ strtolower($module) }}.destroy]">
			<tr>
				<td>{{ $module }}</td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.index']) and $permissions['admin.'.strtolower($module).'.index'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.index]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.view']) and $permissions['admin.'.strtolower($module).'.view'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.view]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.create']) and $permissions['admin.'.strtolower($module).'.create'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.create]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.store']) and $permissions['admin.'.strtolower($module).'.store'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.store]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.edit']) and $permissions['admin.'.strtolower($module).'.edit'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.edit]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.sort']) and $permissions['admin.'.strtolower($module).'.sort'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.sort]"></td>
				<td><input type="checkbox" value="1" @if(isset($permissions['admin.'.strtolower($module).'.destroy']) and $permissions['admin.'.strtolower($module).'.destroy'])checked="checked"@endif name="permissions[admin.{{ strtolower($module) }}.destroy]"></td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
