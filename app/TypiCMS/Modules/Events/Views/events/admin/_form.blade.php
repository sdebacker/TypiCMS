
@section('js')
	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Form::hidden('id'); }}

	<div class="col-sm-6">

		<div class="row form-group">
			<div class="col-xs-8">
				{{ Form::label('start_date', trans('validation.attributes.start_date'), array('class' => 'control-label', 'placeholder' => 'DDMMYYYY')) }}
				<div class="input-group">
					{{ Form::text('start_date', null, array('class' => 'form-control datepicker datepicker-start')) }}
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-4">
				{{ Form::label('start_time', trans('validation.attributes.start_time'), array('class' => 'control-label', 'placeholder' => 'HH:MM')) }}
				<div class="input-group">
					{{ Form::text('start_time', null, array('class' => 'form-control timepicker')) }}
					<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
				</div>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-xs-8">
				{{ Form::label('end_date', trans('validation.attributes.end_date'), array('class' => 'control-label', 'placeholder' => 'DDMMYYYY')) }}
				<div class="input-group">
					{{ Form::text('end_date', null, array('class' => 'form-control datepicker datepicker-end')) }}
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-4">
				{{ Form::label('end_time', trans('validation.attributes.end_time'), array('class' => 'control-label', 'placeholder' => 'HH:MM')) }}
				<div class="input-group">
					{{ Form::text('end_time', null, array('class' => 'form-control timepicker')) }}
					<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
				</div>
			</div>
		</div>

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				<div class="form-group">
					{{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
					{{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'input-lg form-control')) }}
				</div>
				<div class="form-group @if($errors->has($lang.'.slug'))has-error@endif">
					{{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
					{{ Form::text($lang.'[slug]', $model->$lang->slug, array('class' => 'form-control')) }}
					@if($errors->has($lang.'.slug'))
					<span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
					@endif
				</div>
				<div class="form-group">
					<label class="checkbox">
						{{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
					</label>
				</div>
				<div class="form-group">
					{{ Form::label($lang.'[summary]', trans('validation.attributes.summary')) }}
					{{ Form::textarea($lang.'[summary]', $model->$lang->summary, array('class' => 'form-control', 'rows' => 4)) }}
				</div>
				<div class="form-group">
					{{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
					{{ Form::textarea($lang.'[body]', $model->$lang->body, array('class' => 'editor form-control')) }}
				</div>
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">
	@include('files.admin._list', array('files' => $model->files))
	</div>

</div>
