    <div class="form-group">
        <button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
        <button class="btn-default btn" type="submit">@lang('validation.attributes.save')</button>
        <a class="btn btn-default" href="{{ route('admin.' . $model->route . '.index') }}">@lang('validation.attributes.exit')</a>
        @if ($model->id)
        {{-- <a class="btn btn-default pull-right" href="{{ TypiCMS::getPublicUrl(null, true) }}">@lang('validation.attributes.preview')</a> --}}
        @endif
    </div>
