@section('js')
    {{ HTML::script(asset('js/form.js')) }}
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}

@include('admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
        <div class="form-group">
            {{ Form::label($lang.'[title]', trans('validation.attributes.title')) }}
            {{ Form::text($lang.'[title]', $model->$lang->title, array('autofocus' => 'autofocus', 'class' => 'form-control')) }}
        </div>
        <div class="form-group @if($errors->has($lang.'.slug'))has-error@endif">
            {{ Form::label($lang.'[slug]', trans('validation.attributes.slug')) }}
            <div class="input-group">
                {{ Form::text($lang.'[slug]', $model->$lang->slug, array('class' => 'form-control')) }}
                <span class="input-group-btn">
                    <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger@endif" type="button">@lang('validation.attributes.generate')</button>
                </span>
            </div>
            @if($errors->has($lang.'.slug'))
            <span class="help-block">{{ $errors->first($lang.'.slug') }}</span>
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
