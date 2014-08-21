@section('titleLeftButton')
    @include('admin._button-back', ['table' => $model->route])
@stop

@include('admin._buttons-form')

<div class="row">

    {{ Form::hidden('id'); }}
    {{ Form::hidden('locale', App::getLocale()); }}
    {{ Form::honeypot('my_name', 'my_time') }}
    {{ Form::hidden('my_time', Crypt::encrypt(time()-60)); }}

    <div class="col-sm-6">

        {{-- Title --}}
        <div class="row">
            <div class="col-xs-6 form-group @if($errors->has('title'))has-error @endif">
                {{ Form::label('title', trans('validation.attributes.title'), array('class' => 'control-label')) }}
                {{ Form::text('title', null, array('class' => 'form-control')) }}
                {{ $errors->first('title', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        {{-- First name --}}
        <div class="form-group @if($errors->has('first_name'))has-error @endif">
            {{ Form::label('first_name', trans('validation.attributes.first_name'), array('class' => 'control-label')) }}
            {{ Form::text('first_name', null, array('class' => 'form-control')) }}
            {{ $errors->first('first_name', '<p class="help-block">:message</p>') }}
        </div>

        {{-- Last name --}}
        <div class="form-group @if($errors->has('last_name'))has-error @endif">
            {{ Form::label('last_name', trans('validation.attributes.last_name'), array('class' => 'control-label')) }}
            {{ Form::text('last_name', null, array('class' => 'form-control')) }}
            {{ $errors->first('last_name', '<p class="help-block">:message</p>') }}
        </div>

        {{-- Email --}}
        <div class="form-group @if($errors->has('email'))has-error @endif">
            {{ Form::label('email', trans('validation.attributes.email'), array('class' => 'control-label')) }}
            {{ Form::text('email', null, array('class' => 'form-control')) }}
            {{ $errors->first('email', '<p class="help-block">:message</p>') }}
        </div>

        {{-- Message --}}
        <div class="form-group @if($errors->has('message'))has-error @endif">
            {{ Form::label('message', trans('validation.attributes.message'), array('class' => 'control-label')) }}
            {{ Form::textarea('message', null, array('class' => 'form-control', 'rows' => 5)) }}
            {{ $errors->first('message', '<p class="help-block">:message</p>') }}
        </div>

    </div>

    <div class="col-sm-6">

        <div class="row">
            {{-- Language --}}
            <div class="col-xs-6 form-group @if($errors->has('language'))has-error @endif">
                {{ Form::label('language', trans('validation.attributes.language'), array('class' => 'control-label')) }}
                {{ Form::text('language', null, array('class' => 'form-control')) }}
                {{ $errors->first('language', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        <div class="row">
            {{-- Website --}}
            <div class="col-xs-6 form-group @if($errors->has('website'))has-error @endif">
                {{ Form::label('website', trans('validation.attributes.website'), array('class' => 'control-label')) }}
                {{ Form::text('website', null, array('class' => 'form-control')) }}
                {{ $errors->first('website', '<p class="help-block">:message</p>') }}
            </div>

            {{-- Company --}}
            <div class="col-xs-6 form-group @if($errors->has('company'))has-error @endif">
                {{ Form::label('company', trans('validation.attributes.company'), array('class' => 'control-label')) }}
                {{ Form::text('company', null, array('class' => 'form-control')) }}
                {{ $errors->first('company', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        {{-- Address --}}
        <div class="form-group @if($errors->has('address'))has-error @endif">
            {{ Form::label('address', trans('validation.attributes.address'), array('class' => 'control-label')) }}
            {{ Form::text('address', null, array('class' => 'form-control')) }}
            {{ $errors->first('address', '<p class="help-block">:message</p>') }}
        </div>

        <div class="row">
            {{-- Postcode --}}
            <div class="col-xs-6 form-group @if($errors->has('postcode'))has-error @endif">
                {{ Form::label('postcode', trans('validation.attributes.postcode'), array('class' => 'control-label')) }}
                {{ Form::text('postcode', null, array('class' => 'form-control')) }}
                {{ $errors->first('postcode', '<p class="help-block">:message</p>') }}
            </div>

            {{-- City --}}
            <div class="col-xs-6 form-group @if($errors->has('city'))has-error @endif">
                {{ Form::label('city', trans('validation.attributes.city'), array('class' => 'control-label')) }}
                {{ Form::text('city', null, array('class' => 'form-control')) }}
                {{ $errors->first('city', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        {{-- Country --}}
        <div class="form-group @if($errors->has('country'))has-error @endif">
            {{ Form::label('country', trans('validation.attributes.country'), array('class' => 'control-label')) }}
            {{ Form::text('country', null, array('class' => 'form-control')) }}
            {{ $errors->first('country', '<p class="help-block">:message</p>') }}
        </div>

        <div class="row">
            {{-- Phone --}}
            <div class="col-xs-6 form-group @if($errors->has('phone'))has-error @endif">
                {{ Form::label('phone', trans('validation.attributes.phone'), array('class' => 'control-label')) }}
                {{ Form::text('phone', null, array('class' => 'form-control')) }}
                {{ $errors->first('phone', '<p class="help-block">:message</p>') }}
            </div>

            {{-- Mobile --}}
            <div class="col-xs-6 form-group @if($errors->has('mobile'))has-error @endif">
                {{ Form::label('mobile', trans('validation.attributes.mobile'), array('class' => 'control-label')) }}
                {{ Form::text('mobile', null, array('class' => 'form-control')) }}
                {{ $errors->first('mobile', '<p class="help-block">:message</p>') }}
            </div>
        </div>

        {{-- Fax --}}
        <div class="form-group @if($errors->has('fax'))has-error @endif">
            {{ Form::label('fax', trans('validation.attributes.fax'), array('class' => 'control-label')) }}
            {{ Form::text('fax', null, array('class' => 'form-control')) }}
            {{ $errors->first('fax', '<p class="help-block">:message</p>') }}
        </div>

    </div>

</div>
