@section('main')

	<div class="place-page">

		@if (count($places))

			<ul class="list-unstyled addresses">
				@foreach($places as $place)
				<li id="item-{{ $place->id }}">
					<div class="row">
						<div class="col-xs-9">
							<a class="fancybox" data-fancybox-type="iframe" href="{{ route($lang.'.places.slug', array($place->slug)) }}">
								<strong>{{ $place->title }}</strong>
							</a>
							<p>
								<small>
								@if ($place->address)
									{{ $place->address }}<br>
								@endif
								@if ($place->phone)
									T {{ $place->phone }}<br>
								@endif
								@if ($place->fax)
									F {{ $place->fax }}<br>
								@endif
								@if ($place->email)
									<a href="mailto:{{ $place->email }}">{{ $place->email }}</a><br>
								@endif
								@if ($place->website)
									<a href="{{ $place->website }}" target="_blank">{{ $place->website }}</a><br>
								@endif
								</small>
							</p>
						</div>
						<div class="col-xs-3 btns">
							<a class="fancybox" data-fancybox-type="iframe" href="{{ route($lang.'.places.slug', array($place->slug)) }}">
								<span class="glyphicon glyphicon-plus"></span><span class="sr-only">{{ trans('public.More') }}</span>
							</a>
						</div>
					</div>
				</li>
				@endforeach
			</ul>

		@endif

	</div>

@stop