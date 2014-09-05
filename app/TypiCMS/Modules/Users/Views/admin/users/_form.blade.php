@section('js')
    {{ HTML::script('js/admin/checkboxes-permissions.js') }}
@stop

@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

{{ Form::hidden('activated') }}
{{ Form::hidden('id') }}

<div class="row">

    <div class="col-sm-6">

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group @if($errors->has('email'))has-error @endif">
                    {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
                    {{ Form::email('email', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
                    {{ $errors->first('email', '<p class="help-block">:message</p>') }}
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group @if($errors->has('password'))has-error @endif">
                    {{ Form::label('password', trans('validation.attributes.password'), array('class' => 'control-label')) }}
                    {{ Form::password('password', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                    {{ $errors->first('password', '<p class="help-block">:message</p>') }}
                </div>
                <div class="form-group @if($errors->has('password_confirmation'))has-error @endif">
                    {{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'control-label')) }}
                    {{ Form::password('password_confirmation', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                    {{ $errors->first('password_confirmation', '<p class="help-block">:message</p>') }}
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-6">

                <div class="form-group @if($errors->has('first_name'))has-error @endif">
                    {{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
                    {{ Form::text('first_name', null, array('class' => 'form-control')); }}
                    {{ $errors->first('first_name', '<p class="help-block">:message</p>') }}
                </div>

            </div>

            <div class="col-sm-6">

                <div class="form-group @if($errors->has('last_name'))has-error @endif">
                    {{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
                    {{ Form::text('last_name', null, array('class' => 'form-control')); }}
                    {{ $errors->first('last_name', '<p class="help-block">:message</p>') }}
                </div>

            </div>

        </div>

        <div class="checkbox">
            <label>
                {{ Form::hidden('activated', 0) }}
                {{ Form::checkbox('activated', 1, isset($user) && $user->isActivated()) }} Activé
            </label>
        </div>

        <div class="row">

            <div class="col-sm-6">

                <div class="form-group">
                <label>@lang('validation.attributes.groups')</label>
                @foreach ($groups as $group)
                <div class="checkbox">
                    <label>
                        {{ Form::hidden('groups[' . $group->id . ']', 0) }}
                        {{ Form::checkbox('groups[' . $group->id . ']', 1, isset($selectedGroups[$group->id])) }} {{ $group->name }}
                    </label>
                </div>
                @endforeach
                </div>

            </div>

        </div>

    </div>

</div>

<label>@lang('users::global.User permissions')</label>
<div class="checkbox">
    <label>
        {{ Form::hidden('permissions[superuser]', 0) }}
        {{ Form::checkbox('permissions[superuser]', 1, isset($permissions['superuser']) && $permissions['superuser']) }} Superuser ?
    </label>
</div>
@include('admin._permissions-form')
