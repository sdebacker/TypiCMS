@section('head')
	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Form::hidden('id'); }}

	<div class="col-sm-6">

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				<div class="form-group">
					{{ Form::label($lang.'[alt_attribute]', trans('validation.attributes.alt_attribute')) }}
					{{ Form::text($lang.'[alt_attribute]', $model->$lang->alt_attribute, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label($lang.'[description]', trans('validation.attributes.description')) }}
					{{ Form::textarea($lang.'[description]', $model->$lang->description, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label($lang.'[keywords]', trans('validation.attributes.keywords')) }}
					{{ Form::text($lang.'[keywords]', $model->$lang->keywords, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					<label class="checkbox">
						{{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
					</label>
				</div>
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">

		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('folder_id', trans('validation.attributes.folder_id')) }}
				{{ Form::text('folder_id', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('user_id', trans('validation.attributes.user_id')) }}
				{{ Form::text('user_id', null, array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('type', trans('validation.attributes.type')) }}
				{{ Form::text('type', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('position', trans('validation.attributes.position')) }}
				{{ Form::text('position', null, array('class' => 'form-control')) }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('path', trans('validation.attributes.path')) }}
				{{ Form::text('path', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('filename', trans('validation.attributes.filename')) }}
				{{ Form::text('filename', null, array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('extension', trans('validation.attributes.extension')) }}
				{{ Form::text('extension', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('mimetype', trans('validation.attributes.mimetype')) }}
				{{ Form::text('mimetype', null, array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('width', trans('validation.attributes.width')) }}
				{{ Form::text('width', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('height', trans('validation.attributes.height')) }}
				{{ Form::text('height', null, array('class' => 'form-control')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 form-group">
				{{ Form::label('user_id', trans('validation.attributes.download_count')) }}
				{{ Form::text('download_count', null, array('class' => 'form-control')) }}
			</div>
			<div class="col-sm-6 form-group">
				{{ Form::label('name', trans('validation.attributes.name')) }}
				{{ Form::text('name', null, array('class' => 'form-control')) }}
			</div>
		</div>

	</div>

</div>
