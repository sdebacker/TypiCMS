<div class="row">

	<div class="form-group col-sm-12">
		{{ Former::primary_button()->type('submit')->value('save') }}
		{{ Former::primary_button()->type('submit')->name('exit')->setAttribute('value', 'true')->value('save and exit') }}
		{{ Former::link()->class('btn btn-default')->href(route('admin.menus.menulinks.index', $menu->id))->value('Annuler') }}
	</div>

	{{ Former::hidden('id'); }}

	<div class="col-sm-6">

		@include('admin._langTabs')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title'); }}
				{{ Former::text($lang.'[uri]')->label('uri'); }}
				{{ Former::text($lang.'[url]')->label('website'); }}
				{{ Former::checkbox($lang.'[status]')->label('')->text('Online'); }}
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">

		<div class="row">
			<div class="col-sm-6">{{ Former::select('page_id')->options($selectPages)->small(6); }}</div>
			<div class="col-sm-6">{{ Former::select('module_name')->options($selectModules); }}</div>
		</div>

		<div class="row">
			<div class="col-sm-6">{{ Former::select('target')->options(array('' => trans('validation.values.Active tab'), '_blank' => trans('validation.values.New tab'))); }}</div>
			<div class="col-sm-6">{{ Former::text('class'); }}</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">{{ Former::text('restricted_to'); }}</div>
			<div class="col-sm-6">{{ Former::text('link_type'); }}</div>
		</div>

	</div>

</div>

{{ Former::hidden('menu_id', $menu->id); }}
{{ Former::hidden('position'); }}
{{ Former::hidden('parent'); }}
{{ Former::hidden('id'); }}
