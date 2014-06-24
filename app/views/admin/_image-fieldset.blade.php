        <div class="clearfix well media @if($errors->has($field))has-error @endif">
            @if($model->$field)
            <div class="pull-left">
                <?php 
                    $file = '/uploads/' . $model->getTable() . '/' . $model->$field; 
                    if(!is_file(public_path() . $file)){
                        $file = '/uploads/img-not-found.png';
                    }
                ?>
                <img class="media-object" src="{{ Croppa::url($file, 150) }}" alt="">
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
