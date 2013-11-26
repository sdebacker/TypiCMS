@if(count($files))
	<h1><span id="nb_elements">{{ $files->getTotal() }}</span> @choice('global.modules.files', $files->getTotal())</h1>

	<div class="row">
	@foreach($files as $file)
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
	
@endif