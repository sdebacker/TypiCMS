        <div class="clearfix well media @if($errors->has('image'))has-error@endif">
            @if($model->image)
            <div class="pull-left">
                <img class="media-object" src="{{ Croppa::url('/uploads/' . $model->getTable() . '/' . $model->image, 150) }}" alt="">
            </div>
            @endif
            <div class="media-body">
                {{ Form::label('image', trans('validation.attributes.image'), array('class' => 'control-label')) }}
                {{ Form::file('image') }}
                <span class="help-block">
                    @lang('validation.attributes.max :size MB', array('size' => 2))
                </span>
            </div>
            @if($errors->has('image'))
            <span class="help-block">{{ $errors->first('image') }}</span>
            @endif
        </div>
