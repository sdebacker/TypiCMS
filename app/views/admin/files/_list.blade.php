
	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> {{ trans_choice('global.modules.files', $models->getTotal()) }}</h1>

	<div class="row">
	@foreach($models as $file)
		<div class="col-md-3 col-xs-6">
			<div class="thumbnail">
				<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 135, 135) }}" alt="{{ $file->alt_attribute }}">
				<div class="caption">
					<p>
						{{ $file->filename }} <br>
						{{ $file->width }} × {{ $file->height }}
					</p>
				</div>
			</div>
		</div>
	@endforeach
	</div>
