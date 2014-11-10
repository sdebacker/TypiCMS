@section('js')
    {{ HTML::script(asset('//tinymce.cachefly.net/4.1/tinymce.min.js')) }}
    {{ HTML::script(asset('js/admin/form.js')) }}
@stop

@include('admin._buttons-form')

{{ Form::hidden('id'); }}
{{ Form::hidden('slug'); }}

<div class="form-group @if($errors->has('tag'))has-error @endif">
    {{ Form::label('tag', trans('validation.attributes.tag'), array('class' => 'control-label')) }}
    {{ Form::text('tag', null, array('class' => 'form-control')) }}
    {{ $errors->first('tag', '<p class="help-block">:message</p>') }}
</div>
