<li id="item_{{ $model->id }}">
	<div>
		{{ $model->checkbox }}
		{{ $model->status }}
		<a href="{{ route('admin.menus.menulinks.edit', array($model->menu_id, $model->id)) }}">{{ $model->title }}</a>
	</div>
	@if ($model->children)
		<ul>
			@foreach ($model->children as $submodel)
				@include('menulinks.admin._listItem', array('model' => $submodel))
			@endforeach
		</ul>
	@endif
</li>
