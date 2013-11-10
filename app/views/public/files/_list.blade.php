
	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> {{ trans_choice('global.modules.files', $models->getTotal()) }}</h1>

	<div class="row">
	@foreach($models as $file)
		<div class="col-sm-3">
			<a href="{{ '/'.$file->path.'/'.$file->filename }}" class="thumbnail">
				<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 504, 504) }}" alt="{{ $file->alt_attribute }}">
				<!-- <div class="caption">
					<p>
					</p>
				</div> -->
			</a>
		</div>
	@endforeach
	</div>
