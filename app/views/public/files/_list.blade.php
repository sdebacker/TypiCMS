@if(count($files))

	<div class="row">
	@foreach($files as $file)
		<div class="col-sm-3 col-md-2 col-xs-4">
			<a href="{{ '/'.$file->path.'/'.$file->filename }}" class="thumbnail">
				<img src="{{ Croppa::url('/'.$file->path.'/'.$file->filename, 310, 310) }}" alt="{{ $file->alt_attribute }}">
				<!-- <div class="caption">
					<p>
					</p>
				</div> -->
			</a>
		</div>
	@endforeach
	</div>

@endif