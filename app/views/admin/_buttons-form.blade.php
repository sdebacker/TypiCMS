    <div class="form-group col-sm-12">
        <button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
        <button class="btn-default btn" type="submit">@lang('validation.attributes.save')</button>
        <a href="{{ route('admin.' . $model->route . '.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
    </div>
