    <div class="form-group">
        <button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
        <button class="btn-default btn" type="submit">@lang('validation.attributes.save')</button>
        @if ($uri = $model->getPublicUri(true))
        <a class="btn btn-default pull-right" href="{{ $uri }}?preview=true">@lang('validation.attributes.preview')</a>
        @endif
    </div>
