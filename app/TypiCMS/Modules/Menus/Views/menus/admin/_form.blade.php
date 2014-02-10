<div class="row">

	@include('admin._buttons-form')
	
	{{ Form::hidden('id'); }}

	<div class="col-sm-6">

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ FormField::{$lang.'[title]'}(array('label' => trans('validation.attributes.title'), 'autofocus' => 'autofocus', 'class' => 'input-lg form-control')) }}
				<div class="form-group">
					<label class="checkbox">
						{{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
					</label>
				</div>
			</div>

			@endforeach

		</div>

		{{ FormField::name(array('label' => trans('validation.attributes.name'))) }}

	</div>

</div>
