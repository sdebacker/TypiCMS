<div class="row">

    @include('admin._buttons-form')

    {{ Form::hidden('id'); }}

    <div class="col-sm-6">

        @include('admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                    {{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'input-lg form-control')) }}
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::hidden($lang.'[status]', 0) }}
                        {{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
            </div>

            @endforeach

        </div>

        <div class="form-group @if($errors->has('name'))has-error@endif">
            {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            @if($errors->has('name'))
            <span class="help-block">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group @if($errors->has('class'))has-error@endif">
            {{ Form::label('class', trans('validation.attributes.class'), array('class' => 'control-label')) }}
            {{ Form::text('class', null, array('class' => 'form-control')) }}
            @if($errors->has('class'))
            <span class="help-block">{{ $errors->first('class') }}</span>
            @endif
        </div>

    </div>

</div>
