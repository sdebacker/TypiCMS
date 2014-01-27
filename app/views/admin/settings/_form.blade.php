@section('head')

	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">
	<div class="form-group col-sm-12">
		{{ Former::primary_button()->type('submit')->value('save') }}
	</div>
</div>

<label>@lang('validation.attributes.websiteTitle')</label>
@foreach ($locales as $lang)
	{{ Former::text($lang.'[websiteTitle]')->prepend(strtoupper($lang))->label(''); }}
@endforeach

<label>@lang('Online')</label>
@foreach ($locales as $lang)
	{{ Former::checkbox($lang.'[status]')->inline()->class('inline')->text($lang)->label(''); }}
@endforeach

{{ Former::text('webmasterEmail'); }}
{{ Former::text('typekitCode'); }}
<div class="row">
	<div class="col-sm-6">
	{{ Former::text('googleAnalyticsUniversalCode'); }}
	</div>
	<div class="col-sm-6">
	{{ Former::text('googleAnalyticsCode'); }}
	</div>
</div>
{{ Former::checkbox('langChooser')->label('')->text('langChooser'); }}
{{ Former::checkbox('authPublic')->label('')->text('authPublic'); }}
{{ Former::checkbox('register')->label('')->text('registration allowed'); }}
