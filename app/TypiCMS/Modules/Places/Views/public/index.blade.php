@section('styles')
	@parent
	<style>
		h1,h2,h3,h4,h5,h6, a { color: #{{ $chapter->color }}; }
	</style>
@stop

@section('main')

	<ol class="breadcrumb">
		<li><a href="{{ route($lang) }}"><span class="glyphicon glyphicon-search"></span></a></li>
		<li><a href="{{ route($lang.'.chapter', $chapter->slug) }}">{{ $chapter->title }}</a></li>
		<li>{{ $category->title }}</li>
	</ol>

	<div class="place-page">

		@if($chapter->ad)
		<p class="text-center">
			@if($chapter->adlink)
			<a href="{{ $chapter->adlink }}" target="_blank">
			@endif
				<img class="img-responsive img-ad" src="/uploads/categories/{{ $chapter->ad }}">
			@if($chapter->adlink)
			</a>
			@endif
		</p>
		@endif

		<h2>{{ $category->title }}</h2>

		@if($category->ad)
		<p class="text-center">
			@if($category->adlink)
			<a href="{{ $category->adlink }}" target="_blank">
			@endif
				<img class="img-responsive img-ad" src="/uploads/categories/{{ $category->ad }}">
			@if($category->adlink)
			</a>
			@endif
		</p>
		@endif

		{{ $category->body }}

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

		@foreach($subcategories as $subcategory)
			<h3 id="{{ $subcategory->slug }}">{{ $subcategory->title }}</h3>

			@if($subcategory->ad)
			<p class="text-center">
				@if($subcategory->adlink)
				<a href="{{ $subcategory->adlink }}" target="_blank">
				@endif
					<img class="img-responsive img-ad" src="/uploads/categories/{{ $subcategory->ad }}">
				@if($subcategory->adlink)
				</a>
				@endif
			</p>
			@endif

			{{ $subcategory->body }}

			<ul class="list-unstyled addresses">
				@foreach($subcategory->places as $place)
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
		@endforeach

		<p>
			<a href="./" style="background-color: #{{ $chapter->color }}" class="btn btn-back">Retour à {{ $chapter->title }}</a>
		</p>

	</div>

@stop