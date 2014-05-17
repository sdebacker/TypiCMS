@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
@stop


<div class="row">

    @include('admin._buttons-form')

    {{ Form::hidden('id'); }}

    <div class="col-sm-12">

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#content" data-target="#content" data-toggle="tab">@lang('Content')</a>
            </li>
            <li>
                <a href="#meta" data-target="#meta" data-toggle="tab">@lang('Meta')</a>
            </li>
            <li>
                <a href="#options" data-target="#options" data-toggle="tab">@lang('Options')</a>
            </li>
        </ul>

        <div class="tab-content">

            {{-- Content --}}
            <div class="tab-pane fade in active" id="content">

                @include('admin._tabs-lang-form', ['target' => 'content'])

                <div class="tab-content">

                @foreach ($locales as $lang)

                    <div class="tab-pane fade in @if ($locale == $lang)active@endif" id="content-{{ $lang }}">

                        <div class="row">

                            <div class="col-md-6 form-group">
                                {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
                                {{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
                            </div>

                            <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error@endif">
                                {{ Form::label($lang.'[slug]', trans('validation.attributes.url'), array('class' => 'control-label')) }}
                                <div class="input-group">
                                    <span class="input-group-addon">{{ $model->present()->parentUri($lang) }}</span>
                                    {{ Form::text($lang.'[slug]', $model->$lang->slug, array('class' => 'form-control')) }}
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger@endif" type="button">Générer</button>
                                    </span>
                                </div>
                                @if($errors->has($lang.'.slug'))
                                <span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
                                @endif
                            </div>

                        </div>

                        {{ Form::hidden($lang.'[uri]') }}

                        <div class="form-group">
                            <label class="checkbox">
                                {{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
                            </label>
                        </div>

                        <div class="form-group">
                            {{ Form::label($lang.'[body]', trans('validation.attributes.body'), array('class' => 'sr-only')) }}
                            {{ Form::textarea($lang.'[body]', $model->$lang->body, array('class' => 'editor form-control')) }}
                        </div>
                    
                    </div>
                    
                @endforeach

                </div>

            </div>

            {{-- Metadata --}}
            <div class="tab-pane fade in" id="meta">

                @include('admin._tabs-lang-form', ['target' => 'meta'])

                <div class="tab-content">

                {{-- Headers --}}
                @foreach ($locales as $lang)

                <div class="tab-pane fade in @if ($locale == $lang)active@endif" id="meta-{{ $lang }}">

                    <div class="form-group">
                        {{ Form::label($lang.'[meta_title]', trans('validation.attributes.meta_title')) }}
                        {{ Form::text($lang.'[meta_title]', $model->$lang->meta_title, array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label($lang.'[meta_keywords]', trans('validation.attributes.meta_keywords')) }}
                        {{ Form::text($lang.'[meta_keywords]', $model->$lang->meta_keywords, array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label($lang.'[meta_description]', trans('validation.attributes.meta_description')) }}
                        {{ Form::text($lang.'[meta_description]', $model->$lang->meta_description, array('class' => 'form-control')) }}
                    </div>

                </div>

                @endforeach

                </div>

            </div>

            {{-- Options --}}
            <div class="tab-pane fade in" id="options">

                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox('rss_enabled') }} @lang('validation.attributes.rss_enabled')
                    </label>
                </div>

                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox('comments_enabled') }} @lang('validation.attributes.comments_enabled')
                    </label>
                </div>

                <div class="form-group">
                    @if ($model->is_home)
                        <label class="checkbox text-muted">
                            {{ Form::checkbox('is_home', null, null, array('disabled', 'disabled')) }} @lang('validation.attributes.is_home')
                            {{ Form::hidden('is_home') }}
                        </label>
                    @else
                        <label class="checkbox">
                            {{ Form::checkbox('is_home') }} @lang('validation.attributes.is_home')
                        </label>
                    @endif
                </div>

                <div class="form-group @if($errors->has('template'))has-error@endif">
                    {{ Form::label('template', trans('validation.attributes.template'), array('class' => 'control-label')) }}
                    {{ Form::text('template', null, array('class' => 'form-control')) }}
                    @if($errors->has('template'))
                    <span class="help-block">{{ $errors->first('template') }}</span>
                    @endif
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
    
    </div>

</div>

