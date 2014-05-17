@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

    @include('admin._buttons-form')

    {{ Form::hidden('id'); }}

    <div class="col-sm-6">

        <div class="row">
            <div class="col-xs-8 form-group @if($errors->has('start_date'))has-error@endif">
                {{ Form::label('start_date', trans('validation.attributes.start_date'), array('class' => 'control-label')) }}
                <div class="input-group picker-date picker-date-start">
                    {{ Form::text('start_date', $model->present()->dateOrNow('start_date', 'd.m.Y'), array('class' => 'form-control', 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
                @if($errors->has('start_date'))
                <span class="help-block">{{ $errors->first('start_date') }}</span>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {{ Form::label('start_time', trans('validation.attributes.start_time'), array('class' => 'control-label')) }}
                <div class="input-group picker-time">
                    {{ Form::text('start_time', null, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-8 form-group @if($errors->has('end_date'))has-error@endif">
                {{ Form::label('end_date', trans('validation.attributes.end_date'), array('class' => 'control-label')) }}
                <div class="input-group picker-date picker-date-end">
                    {{ Form::text('end_date', $model->present()->dateOrNow('end_date', 'd.m.Y'), array('class' => 'form-control', 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
                @if($errors->has('end_date'))
                <span class="help-block">{{ $errors->first('end_date') }}</span>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {{ Form::label('end_time', trans('validation.attributes.end_time'), array('class' => 'control-label')) }}
                <div class="input-group picker-time">
                    {{ Form::text('end_time', null, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-clock-o"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        @include('admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                    {{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
                </div>
                <div class="form-group @if($errors->has($lang.'.slug'))has-error@endif">
                    {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                    {{ Form::text($lang.'[slug]', $model->$lang->slug, array('class' => 'form-control')) }}
                    @if($errors->has($lang.'.slug'))
                    <span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[summary]', trans('validation.attributes.summary')) }}
                    {{ Form::textarea($lang.'[summary]', $model->$lang->summary, array('class' => 'form-control', 'rows' => 4)) }}
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
                    {{ Form::textarea($lang.'[body]', $model->$lang->body, array('class' => 'editor form-control')) }}
                </div>
            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">
    </div>

</div>
