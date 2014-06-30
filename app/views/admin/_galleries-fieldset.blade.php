        <div class="form-group">
            {{ Form::label('galleries', trans('validation.attributes.galleries'), array('class' => 'control-label')) }}
            <span class="help-text text-muted">@lang('global.Drag and drop to sort')</span>
            {{ Form::select(
                'galleries[]',
                $model->galleries->lists('name', 'id') + Galleries::getModel()->lists('name', 'id'),
                $model->galleries->lists('id'),
                array(
                    'class' => 'form-control',
                    'id' => 'galleries',
                    'multiple'
                )
            ) }}
        </div>
