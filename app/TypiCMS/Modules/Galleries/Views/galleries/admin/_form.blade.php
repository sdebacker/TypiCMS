@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@section('otherSideLink')
    @include('admin._navbar-public-link')
@stop


@include('admin._buttons-form')

{{ Form::hidden('id'); }}

<ul class="nav nav-tabs">
    <li class="@if (input::get('tab') != 'tab-files')active @endif">
        <a href="#tab-main" data-target="#tab-main" data-toggle="tab">@lang('global.Content')</a>
    </li>
    <li class="@if (input::get('tab') == 'tab-files')active @endif">
        <a href="#tab-files" data-target="#tab-files" data-toggle="tab">@lang('global.Files')</a>
    </li>
</ul>

<div class="tab-content">

    {{-- Main tab --}}
    <div class="tab-pane fade in @if (input::get('tab') != 'tab-files')active @endif" id="tab-main">

        <div class="form-group @if($errors->has('name'))has-error @endif">
            {{ Form::label('name', trans('validation.attributes.name'), array('class' => 'control-label')) }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            {{ $errors->first('name', '<p class="help-block">:message</p>') }}
        </div>


        @include('admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                <div class="form-group">
                    {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                    {{ Form::text($lang.'[title]', $model->translate($lang)->title, array('class' => 'form-control')) }}
                </div>
                <div class="form-group @if($errors->has($lang.'.slug'))has-error @endif">
                    {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                        </span>
                    </div>
                    {{ $errors->first($lang.'.slug', '<p class="help-block">:message</p>') }}
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox($lang.'[status]', 1, $model->translate($lang)->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::label($lang.'[body]', trans('validation.attributes.body')) }}
                    {{ Form::textarea($lang.'[body]', $model->translate($lang)->body, array('class' => 'editor form-control')) }}
                </div>
            </div>

            @endforeach

        </div>

    </div>
    
    {{-- Galleries tab --}}
    <div class="tab-pane fade in @if (input::get('tab') == 'tab-files')active @endif" id="tab-files">

        @if ($model->id)
            @include('galleries.admin.files')
        @else
            <p class="alert alert-info">@lang('galleries::global.Save your gallery, then add files.')</p>
        @endif

    </div>

</div>
