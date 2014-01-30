@section('languagesMenu') @stop
@section('header')        @stop
@section('mainMenu')      @stop
@section('footer')    @stop

@section('main')

	<div class="row">

		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

			<h1 class="text-center">Choose language</h1>


			<div class="btn-group btn-group-justified">

				@foreach ($locales as $locale)

				<a href="{{ route($locale) }}" class="btn btn-default btn-lg">{{ trans('public.languages.'.$locale) }}</a>

				@endforeach

			</div>

		</div>

	</div>

@stop
