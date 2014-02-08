@section('css')
	{{ HTML::style(asset('css/gmaps.css')) }}
@stop

@section('js')
	{{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language='.Config::get('app.locale'))) }}
	{{ HTML::script(asset('js/gmaps.js')) }}
@stop

@section('main')

	<h1>Places</h1>
	<div class="row">

		<div class="col-sm-4">
			
			<form method="get" role="form">
				<label for="string" class="sr-only">Search</label>
				<div class="input-group">
					<input id="string" type="text" placeholder="search" name="string" class="form-control input-sm">
					<span class="input-group-btn">
						<button type="submit" value="search" class="btn btn-sm btn-primary">Search</button>
					</span>
				</div>
			</form>

			<h2>
			{{ count($places) }} @choice('places', count($places))
			@if(Input::get('string')) @lang('for')
				“{{ Input::get('string') }}”
			@endif
			</h2>

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