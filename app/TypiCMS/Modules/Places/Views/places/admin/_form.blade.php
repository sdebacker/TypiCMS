@section('js')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}
	{{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language=fr')) }}
	{{ HTML::script(asset('js/gmaps.admin.js')) }}

@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Former::hidden('id'); }}

	<div class="col-sm-6">

		{{ Former::lg_text('title')->label('title')->autofocus(); }}

		{{ Former::text('slug')->label('slug'); }}

		{{ Former::checkbox('status')->text('Online')->label('')->check(); }}

		<div class="row">

			@foreach ($locales as $lang)

			<fieldset class="col-sm-6" id="{{ $lang }}">
				<legend>{{ trans('global.languages.'.$lang) }}</legend>
				{{ Former::textarea($lang.'[info]')->label('info')->rows(10)->value(''); }}
			</fieldset>

			@endforeach

		</div>


	</div>

	<div class="col-sm-6">

		{{ Former::text('address')->label('address'); }}

		<div class="row">
			<div class="col-sm-6">
				{{ Former::text('email'); }}
			</div>
			<div class="col-sm-6">
				{{ Former::text('website', null, 'http://'); }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				{{ Former::text('phone'); }}
			</div>
			<div class="col-sm-6">
				{{ Former::text('fax'); }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				{{ Former::text('latitude'); }}
			</div>
			<div class="col-sm-6">
				{{ Former::text('longitude'); }}
			</div>
		</div>

		<div class="clearfix well">
			@if(isset($model->logo) and $model->logo)
			<div class="thumbnail">
				<img src="/uploads/{{ $model->getTable() }}/{{ $model->logo }}" alt="">
			</div>
			<div class="pull-left">
				{{ Former::file('logo')->label('replace logo')->help('max 500 Ko'); }}
			</div>
			@else
			{{ Former::file('logo')->help('max 500 Ko'); }}
			@endif
		</div>

		<div class="clearfix well">
			@if(isset($model->image) and $model->image)
			<div class="thumbnail">
				<img src="/uploads/{{ $model->getTable() }}/{{ $model->image }}" alt="">
			</div>
			<div class="pull-left">
				{{ Former::file('image')->label('replace image')->help('max 2000 Ko'); }}
			</div>
			@else
			{{ Former::file('image')->help('max 2000 Ko'); }}
			@endif
		</div>

	</div>

</div>
