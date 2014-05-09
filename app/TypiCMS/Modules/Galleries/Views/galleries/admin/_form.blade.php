@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
@stop

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

    @if ($model->id)
        <iframe class="col-sm-6" height="1000" src="/admin/files?view=gallery&amp;gallery_id={{ $model->id }}" frameborder="0"></iframe>
    @else
        <div class="col-sm-6">
            <p class="alert alert-info">Create the gallery, then add files</p>
        </div>
    @endif

</div>
