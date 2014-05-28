        <div class="form-group">
            {{ Form::label('galleries', trans('validation.attributes.galleries'), array('class' => 'control-label')) }}
            <span class="help-text text-muted">@lang('global.Drag and drop to sort')</span>
            {{ Form::text('galleries', $galleries, array('id' => 'select-galleries', 'class' => 'form-control')) }}
        </div>
