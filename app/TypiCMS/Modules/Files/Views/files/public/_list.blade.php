@if(count($files))

	@foreach(array_chunk($files->all(), 4) as $row)
		<div class="row">
		@foreach($row as $file)
			<div class="col-xs-3">
				<a href="{{ '/'.$file->path.'/'.$file->filename }}" class="thumbnail fancybox" rel="gallery">
					<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 310, 310) }}" alt="{{ $file->alt_attribute }}">
					<!-- <div class="caption">
						<p>
						</p>
					</div> -->
				</a>
			</div>
		@endforeach
		</div>
	@endforeach

@endif