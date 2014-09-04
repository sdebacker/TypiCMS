@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('admin._navbar-public-link')
@stop

@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}

<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li>
        <a href="#tab-galleries" data-target="#tab-galleries" data-toggle="tab">@lang('global.Galleries')</a>
    </li>
    <li>
        <a href="#tab-meta" data-target="#tab-meta" data-toggle="tab">@lang('global.Meta')</a>
    </li>
    <li>
        <a href="#tab-options" data-target="#tab-options" data-toggle="tab">@lang('global.Options')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in active" id="tab-main">

        @include('admin._tabs-lang-form', ['target' => 'content'])

        <div class="tab-content">

        @foreach ($locales as $lang)

            <div class="tab-pane fade in @if ($locale == $lang)active @endif" id="content-{{ $lang }}">

                <div class="row">
                    <div class="col-md-6 form-group">
                        {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                        {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
                    </div>
                    <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                        {{ Form::label($lang.'[slug]', trans('validation.attributes.url'), array('class' => 'control-label')) }}
                        <div class="input-group">
                            <span class="input-group-addon">{{ $model->present()->parentUri($lang) }}</span>
                            {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                            </span>
                        </div>
                        {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                    </div>
                </div>

                {{ Form::hidden($lang.'[uri]') }}

                <div class="checkbox">
                    <label>
                        {{ Form::checkbox($lang.'[status]', 1, $model->translate($lang)->status) }} @lang('validation.attributes.online')
                    </label>
                </div>

                <div class="form-group">
                    {{ Form::label($lang.'[body]', trans('validation.attributes.body'), array('class' => 'sr-only')) }}
                    {{ Form::textarea($lang.'[body]', $model->translate($lang)->body, array('class' => 'editor form-control')) }}
                </div>
            
            </div>
            
        @endforeach

        </div>

    </div>

    {{-- Galleries tab --}}
    <div class="tab-pane fade in" id="tab-galleries">

        @include('admin._galleries-fieldset')

    </div>

    {{-- Metadata tab --}}
    <div class="tab-pane fade in" id="tab-meta">

        @include('admin._tabs-lang-form', ['target' => 'meta'])

        <div class="tab-content">

        {{-- Headers --}}
        @foreach ($locales as $lang)

        <div class="tab-pane fade in @if ($locale == $lang)active @endif" id="meta-{{ $lang }}">

            <div class="form-group">
                {{ Form::label($lang.'[meta_title]', trans('validation.attributes.meta_title')) }}
                {{ Form::text($lang.'[meta_title]', $model->translate($lang)->meta_title, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label($lang.'[meta_keywords]', trans('validation.attributes.meta_keywords')) }}
                {{ Form::text($lang.'[meta_keywords]', $model->translate($lang)->meta_keywords, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label($lang.'[meta_description]', trans('validation.attributes.meta_description')) }}
                {{ Form::text($lang.'[meta_description]', $model->translate($lang)->meta_description, array('class' => 'form-control')) }}
            </div>

        </div>

        @endforeach

        </div>

    </div>

    {{-- Options --}}
    <div class="tab-pane fade in" id="tab-options">

        <div class="checkbox">
            <label>
                {{ Form::checkbox('rss_enabled') }} @lang('validation.attributes.rss_enabled')
            </label>
        </div>

        <div class="checkbox">
            <label>
                {{ Form::checkbox('comments_enabled') }} @lang('validation.attributes.comments_enabled')
            </label>
        </div>

        <div class="checkbox">
            @if ($model->is_home)
                <label class="text-muted">
                    {{ Form::checkbox('is_home', null, null, array('disabled', 'disabled')) }} @lang('validation.attributes.is_home')
                    {{ Form::hidden('is_home') }}
                </label>
            @else
                <label>
                    {{ Form::checkbox('is_home') }} @lang('validation.attributes.is_home')
                </label>
            @endif
        </div>

        <div class="form-group @if($errors->has('template'))has-error @endif">
            {{ Form::label('template', trans('validation.attributes.template'), array('class' => 'control-label')) }}
            {{ Form::text('template', null, array('class' => 'form-control')) }}
            {{ $errors->first('template', '<p class="help-block">:message</p>') }}
        </div>

        <div class="form-group">
            {{ Form::label('css', trans('validation.attributes.css'), array('class' => 'control-label')) }}
            {{ Form::textarea('css', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('js', trans('validation.attributes.js'), array('class' => 'control-label')) }}
            {{ Form::textarea('js', null, array('class' => 'form-control')) }}
        </div>

    </div>

</div>
