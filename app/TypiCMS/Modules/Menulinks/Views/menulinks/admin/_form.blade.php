@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
    {{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

    <div class="form-group col-sm-12">
        <button class="btn-primary btn" type="submit">@lang('validation.attributes.save')</button>
        <button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
        <a href="{{ route('admin.menus.menulinks.index', $menu->id) }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
    </div>

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
                    {{ Form::label($lang.'[uri]', trans('validation.attributes.uri')) }}
                    <div class="input-group">
                        <span class="input-group-addon">/</span>
                        {{ Form::text($lang.'[uri]', $model->$lang->uri, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="form-group @if($errors->has($lang.'.url'))has-error@endif">
                    {{ Form::label($lang.'[url]', trans('validation.attributes.website')) }}
                    {{ Form::text($lang.'[url]', $model->$lang->url, array('class' => 'form-control', 'placeholder' => 'http://')) }}
                    @if($errors->has($lang.'.url'))
                    <span class="help-block">{{ $errors->first($lang.'.url') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="checkbox">
                        {{ Form::checkbox($lang.'[status]', 1, $model->$lang->status) }} @lang('validation.attributes.online')
                    </label>
                </div>
            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">

        <div class="row">
            <div class="col-sm-6 form-group">
                {{ Form::label('page_id', trans('validation.attributes.page_id')) }}
                {{ Form::select('page_id', $selectPages, null, array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-6 form-group">
                {{ Form::label('module_name', trans('validation.attributes.module_name')) }}
                {{ Form::select('module_name', $selectModules, null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 form-group">
                {{ Form::label('target', trans('validation.attributes.target')) }}
                {{ Form::select('target', array('' => trans('validation.values.Active tab'), '_blank' => trans('validation.values.New tab')), null, array('class' => 'form-control')) }}
            </div>
            <div class="col-sm-6">
                {{ Form::label('class', trans('validation.attributes.class')) }}
                {{ Form::text('class', $model->$lang->class, array('class' => 'form-control')) }}
            </div>
        </div>

    </div>

</div>

{{ Form::hidden('menu_id', $menu->id); }}
{{ Form::hidden('position', $model->position ?: 0); }}
{{ Form::hidden('parent', $model->parent ?: 0); }}
{{ Form::hidden('id'); }}
