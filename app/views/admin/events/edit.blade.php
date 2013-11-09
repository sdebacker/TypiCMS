@section('header')

	<h1>Edit {{ trans_choice('global.modules.'.$model->view, 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/'.$model->view.'/'.$model->id)->role('form')->class('col-sm-6') }}

		@include('admin.'.$model->view.'._form')

	{{ Former::close() }}


	<div class="col-sm-6">
		<h2>Fichiers</h2>
		<div class="row">
		@foreach($model->files as $file)
			<div class="col-sm-3">
				<div class="thumbnail">
					<img src="{{ '/'.$file->path.'/'.$file->filename }}" alt="{{ $file->alt_attribute }}">
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
	</div>

@stop