        <div class="clearfix well media @if($errors->has($field))has-error @endif">
            @if($model->$field)
            <div>
                <span class="fa fa-file-text-o fa-3x"></span>
                <a href="/uploads/{{ $model->getTable() }}/{{ $model->$field }}">{{ $model->$field }}</a>
            </div>
            @endif
            <div>
                {{ Form::label($field, trans('validation.attributes.' . $field), array('class' => 'control-label')) }}
                {{ Form::file($field) }}
                <span class="help-block">
                    @lang('validation.attributes.max :size MB', array('size' => 2))
                </span>
                @if($errors->has($field))
                <span class="help-block">{{ $errors->first($field) }}</span>
                @endif
            </div>
        </div>
