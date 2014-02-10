	<div class="form-group col-sm-12">
		<button class="btn-primary btn" type="submit">@lang('validation.attributes.save')</button>
		<button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
		<a href="{{ route('admin.' . $model->view . '.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
	</div>
