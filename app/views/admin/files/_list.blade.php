@if(count($files))
	<div class="thumbnails">
		<p class="thumbnails-title"><strong><span id="nb_elements">{{ $files->getTotal() }}</span> @choice('modules.files.files', $files->getTotal())</strong></p>
	@foreach($files as $file)
		<div class="thumbnail">
			<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 135, 135) }}" alt="{{ $file->alt_attribute }}">
			<div class="caption">
				<p>
					{{ $file->filename }} <br>
					{{ $file->width }} × {{ $file->height }}
				</p>
			</div>
		</div>
	@endforeach
	</div>
@endif