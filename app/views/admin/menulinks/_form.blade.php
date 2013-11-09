<div class="row">

	<div class="col-sm-6">

		@if (count($locales) > 1)
		<ul class="nav nav-pills">
			@foreach ($locales as $lang)
			<li class="@if ($locale == $lang)active@endif">
				<a href="#{{ $lang }}" data-target="#{{ $lang }}" data-toggle="tab">{{ $lang }}</a>
			</li>
			@endforeach
		</ul>
		@endif

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane @if ($locale == $lang)active@endif" id="{{ $lang }}">
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

<div>
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.menus.menulinks.index', $menu->id))->value('Annuler') }}
</div>
