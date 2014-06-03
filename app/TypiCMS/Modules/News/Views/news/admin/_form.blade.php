@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
@stop


@include('admin._buttons-form')

{{ Form::hidden('id') }}

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#content" data-target="#content" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#meta" data-target="#galleries" data-toggle="tab">@lang('global.Galleries')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Content --}}
    <div class="tab-pane fade in active" id="content">

        <div class="form-group @if($errors->has('date'))has-error @endif">
            {{ Form::label('date', trans('validation.attributes.date'), array('class' => 'control-label')) }}
            <div class="input-group picker-datetime col-md-6">
                {{ Form::text('date', $model->present()->dateOrNow('date', 'd.m.Y H:i'), array('class' => 'form-control', 'placeholder' => trans('validation.attributes.DDMMYYYY HHMM'))) }}
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
            @if($errors->has('date'))
            <span class="help-block">{{ $errors->first('date') }}</span>
            @endif
        </div>

        @include('admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade @if($locale == $lang)in active @endif" id="content-{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                    {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
                </div>
                <div class="form-group @if($errors->has($lang.'.slug'))has-error @endif">
                    {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                        </span>
                    </div>
                    @if($errors->has($lang.'.slug'))
                    <span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox($lang.'[status]', 1, $model->translate($lang)->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[summary]', trans('validation.attributes.summary')) }}
                    {{ Form::textarea($lang.'[summary]', $model->translate($lang)->summary, array('class' => 'form-control', 'rows' => 4)) }}
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
                    {{ Form::textarea($lang.'[body]', $model->translate($lang)->body, array('class' => 'editor form-control')) }}
                </div>
            </div>

        @endforeach

        </div>

    </div>

    {{-- Galleries --}}
    <div class="tab-pane fade in active" id="galleries">

        @include('admin._galleries-fieldset')

    </div>

</div>

