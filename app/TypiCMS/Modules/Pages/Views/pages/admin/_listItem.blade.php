<li id="item_{{ $model->id }}">
	<div>
		{{ $model->checkbox }}
		{{ $model->edit }}
		{{ $model->status }}
		{{ $model->title }}
		<div class="attachments">{{ $model->countFiles }}</div>
	</div>
	@if ($model->children)
		<ul>
			@foreach ($model->children as $submodel)
				@include('pages.admin._listItem', array('model' => $submodel))
			@endforeach
		</ul>
	@endif
</li>
