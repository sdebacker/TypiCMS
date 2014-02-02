@section('header') @stop

@section('main')

	<div class="row">

		<div class="col-sm-4 container-results">

			<header>
				<h1 class="text-center">
					<a class="text-center" href="{{ route('root') }}">
						<img class="img-responsive" src="/img/logo-expats.png" alt="{{ Config::get('typicms.websiteTitle') }}">
					</a>
				</h1>
			</header>
			
			<a href="./" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;{{ trans('public.Back') }}</a>

			<h3>{{ count($places).' '.trans_choice('public.results', count($places)).' '.trans('public.for').' “'.Input::get('string').'”' }}</h3>

			<ul class="list-unstyled addresses">
				@foreach($places as $place)
				<li id="item-{{ $place->id }}">
					<div class="row">
						<div class="col-xs-9">
							<strong>{{ $place->title }}</strong>
						</div>
						<div class="col-xs-3 btns">
						@if ($place->latitude and $place->longitude)
							<a class="btn-map" href="" title="{{ trans('public.Show on map') }}"><span class="glyphicon glyphicon-map-marker"></span><span class="sr-only">{{ trans('public.Show on map') }}</span></a>					
						@endif
						<a href="{{ route($lang.'.places.slug', array($place->slug)) }}" title="{{ trans('public.More') }}" class="fancybox" data-fancybox-type="iframe"><span class="glyphicon glyphicon-plus"></span><span class="sr-only">{{ trans('public.More') }}</span></a>
						</div>
					</div>
				</li>
				@endforeach
			</ul>

		</div>

		<div id="map" class="map col-sm-8"></div>

	</div>

@stop