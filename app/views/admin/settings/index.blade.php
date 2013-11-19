@section('header')

	<h1>{{ ucfirst(trans('global.modules.settings')) }}</h1>

@stop


@section('main')

<div class="row">

	<div class="col-sm-6">

	{{ Former::vertical_open()->method('POST')->role('form') }}

		@include('admin.settings._form')

	{{ Former::close() }}

	</div>

	<div class="col-sm-6">

		<div>
			<a href="{{ route('backup') }}" class="btn btn-default"><span class="glyphicon glyphicon-download"></span> Backup DB</a>
		</div>

		<table class="table table-condensed">
			<thead>
				<tr><th colspan="2">System info</th></tr>
			</thead>
			<tbody>
				<tr><td>Environment</td><td><b>{{ App::environment(); }}</b></td></tr>
				<tr><td>setlocale(LC_ALL, 0)</td><td><b><?php echo setlocale(LC_ALL, 0); ?></b></td></tr>
				<tr><td>Suported locales</td><td><b>{{ implode(', ', Config::get('app.locales')); }}</b></td></tr>
				<tr><td>App locale</td><td><b>{{ Config::get('app.locale'); }}</b></td></tr>
				<tr><td>Cache admin</td><td><b><?php echo Config::get('typicms.cacheadmin') ? 'enabled': 'disabled'; ?></b></td></tr>
				<tr><td>Cache public</td><td><b><?php echo Config::get('typicms.cachepublic') ? 'enabled': 'disabled'; ?></b></td></tr>
			</tbody>
		</table>

	</div>

</div>

@stop