@if(count($files))
	<h1><span id="nb_elements">{{ $files->getTotal() }}</span> @choice('global.modules.files', $files->getTotal())</h1>

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
	
@endif