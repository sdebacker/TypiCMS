@section('main')

	<div class="row">

		<div class="col-sm-4 col-sm-offset-4">

			<h1 class="text-center">Choose language</h1>

			<div class="col-sm-6 col-sm-offset-3">

				<div class="btn-group btn-group-justified">

					@foreach ($locales as $locale)

					<a href="{{ route($locale) }}" class="btn btn-default">{{ $locale }}</a>

					@endforeach

				</div>

			</div>

		</div>

	</div>

@stop