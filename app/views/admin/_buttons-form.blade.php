	<div class="form-group col-sm-12">
		{{ Former::primary_button()->type('submit')->value('save') }}
		{{ Former::primary_button()->type('submit')->name('exit')->setAttribute('value', 'true')->value('save and exit') }}
		{{ Former::link()->class('btn btn-default')->href(route('admin.' . $model->view . '.index'))->value('Annuler') }}
	</div>
