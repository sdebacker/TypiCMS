@if(count($files))
	<p class="thumbnails-title"><strong><span id="nb_elements">{{ count($files) }}</span> @choice('files::global.files', count($files))</strong></p>
	<div class="thumbnails">
	@foreach ($files as $file)
		<div class="thumbnail">
			<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 130, 130, array('quadrant' => 'T')) }}" alt="{{ $file->alt_attribute }}">
			<div class="caption">
				<small>{{ $file->filename }}</small>
				<div>{{ $file->width }} × {{ $file->height }} px</div>
			</div>
		</div>
	@endforeach
	</div>
@endif