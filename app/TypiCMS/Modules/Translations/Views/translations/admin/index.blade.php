@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.translations.translations', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.translations.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('modules.translations.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@section('btn-locales') @stop
		@include('admin._buttons-list')
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<th>Key</th>
					@foreach (Config::get('app.locales') as $locale)
						<th>@lang('global.languages.' . $locale)</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
			@foreach ($models as $item)
				<tr id="item_{{ $item['id'] }}">
					<td><input type="checkbox" value="{{ $item['id'] }}"></td>
					<td>{{ $item['key'] }}</td>
					@foreach (Config::get('app.locales') as $locale)
						<td>{{ $item[$locale] or '' }}</td>
					@endforeach
				</tr>
			@endforeach
			</tbody>
		</table>

	</div>

@stop