        <div class="clearfix well media @if($errors->has($field))has-error @endif">
            @if($model->$field)
            <div class="pull-left">
                {{ $model->present()->thumb(150, 150, ['resize']) }}
            </div>
            @endif
            <div class="media-body">
                {{ Form::label($field, trans('validation.attributes.' . $field), array('class' => 'control-label')) }}
                {{ Form::file($field) }}
                <span class="help-block">
                    @lang('validation.attributes.max :size MB', array('size' => 2))
                </span>
            </div>
            @if($errors->has($field))
            <span class="help-block">{{ $errors->first($field) }}</span>
            @endif
        </div>
