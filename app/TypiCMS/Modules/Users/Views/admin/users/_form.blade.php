@section('js')
    {{ HTML::script('js/checkboxes-permissions.js') }}
@stop

<div class="form-group">
    <button class="btn-primary btn" value="true" id="exit" name="exit" type="submit">@lang('validation.attributes.save and exit')</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">@lang('validation.attributes.exit')</a>
</div>

{{ Form::hidden('activated') }}
{{ Form::hidden('id') }}

<div class="row">

    <div class="col-sm-6">

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group @if($errors->has('email'))has-error @endif">
                    {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
                    {{ Form::email('email', null, array('class' => 'form-control', 'autocomplete' => 'off')) }}
                    @if($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group @if($errors->has('password'))has-error @endif">
                    {{ Form::label('password', trans('validation.attributes.password'), array('class' => 'control-label')) }}
                    {{ Form::password('password', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                    @if($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('password_confirmation'))has-error @endif">
                    {{ Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), array('class' => 'control-label')) }}
                    {{ Form::password('password_confirmation', array('class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off')) }}
                    @if($errors->has('password_confirmation'))
                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-6">

                <div class="form-group @if($errors->has('first_name'))has-error @endif">
                    {{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
                    {{ Form::text('first_name', null, array('class' => 'form-control')); }}
                    @if($errors->has('first_name'))
                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>

            </div>

            <div class="col-sm-6">

                <div class="form-group @if($errors->has('last_name'))has-error @endif">
                    {{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
                    {{ Form::text('last_name', null, array('class' => 'form-control')); }}
                    @if($errors->has('last_name'))
                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>

            </div>

        </div>

        <div class="checkbox">
            <label>
                {{ Form::hidden('activated', 0) }}
                {{ Form::checkbox('activated', 1, isset($user) and $user->isActivated()) }} Activé
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
        {{ Form::checkbox('permissions[superuser]', 1, isset($permissions['superuser']) and $permissions['superuser']) }} Superuser ?
    </label>
</div>
@include('admin._permissions-form')
