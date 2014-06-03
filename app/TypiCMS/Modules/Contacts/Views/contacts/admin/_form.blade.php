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
                {{ Form::label('title', trans('validation.attributes.title')) }}
                {{ Form::text('title', null, array('class' => 'form-control')) }}
                @if($errors->has('title'))
                <span class="help-block">{{ $errors->first('title') }}</span>
                @endif
            </div>
        </div>

        {{-- First name --}}
        <div class="form-group @if($errors->has('first_name'))has-error @endif">
            {{ Form::label('first_name', trans('validation.attributes.first_name')) }}
            {{ Form::text('first_name', null, array('class' => 'form-control')) }}
            @if($errors->has('first_name'))
            <span class="help-block">{{ $errors->first('first_name') }}</span>
            @endif
        </div>

        {{-- Last name --}}
        <div class="form-group @if($errors->has('last_name'))has-error @endif">
            {{ Form::label('last_name', trans('validation.attributes.last_name')) }}
            {{ Form::text('last_name', null, array('class' => 'form-control')) }}
            @if($errors->has('last_name'))
            <span class="help-block">{{ $errors->first('last_name') }}</span>
            @endif
        </div>

        {{-- Email --}}
        <div class="form-group @if($errors->has('email'))has-error @endif">
            {{ Form::label('email', trans('validation.attributes.email')) }}
            {{ Form::text('email', null, array('class' => 'form-control')) }}
            @if($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>

        {{-- Message --}}
        <div class="form-group @if($errors->has('message'))has-error @endif">
            {{ Form::label('message', trans('validation.attributes.message')) }}
            {{ Form::textarea('message', null, array('class' => 'form-control', 'rows' => 5)) }}
            @if($errors->has('message'))
            <span class="help-block">{{ $errors->first('message') }}</span>
            @endif
        </div>

    </div>

    <div class="col-sm-6">

        <div class="row">
            {{-- Language --}}
            <div class="col-xs-6 form-group @if($errors->has('language'))has-error @endif">
                {{ Form::label('language', trans('validation.attributes.language')) }}
                {{ Form::text('language', null, array('class' => 'form-control')) }}
                @if($errors->has('language'))
                <span class="help-block">{{ $errors->first('language') }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            {{-- Website --}}
            <div class="col-xs-6 form-group @if($errors->has('website'))has-error @endif">
                {{ Form::label('website', trans('validation.attributes.website')) }}
                {{ Form::text('website', null, array('class' => 'form-control')) }}
                @if($errors->has('website'))
                <span class="help-block">{{ $errors->first('website') }}</span>
                @endif
            </div>

            {{-- Company --}}
            <div class="col-xs-6 form-group @if($errors->has('company'))has-error @endif">
                {{ Form::label('company', trans('validation.attributes.company')) }}
                {{ Form::text('company', null, array('class' => 'form-control')) }}
                @if($errors->has('company'))
                <span class="help-block">{{ $errors->first('company') }}</span>
                @endif
            </div>
        </div>

        {{-- Address --}}
        <div class="form-group @if($errors->has('address'))has-error @endif">
            {{ Form::label('address', trans('validation.attributes.address')) }}
            {{ Form::text('address', null, array('class' => 'form-control')) }}
            @if($errors->has('address'))
            <span class="help-block">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="row">
            {{-- Postcode --}}
            <div class="col-xs-6 form-group @if($errors->has('postcode'))has-error @endif">
                {{ Form::label('postcode', trans('validation.attributes.postcode')) }}
                {{ Form::text('postcode', null, array('class' => 'form-control')) }}
                @if($errors->has('postcode'))
                <span class="help-block">{{ $errors->first('postcode') }}</span>
                @endif
            </div>

            {{-- City --}}
            <div class="col-xs-6 form-group @if($errors->has('city'))has-error @endif">
                {{ Form::label('city', trans('validation.attributes.city')) }}
                {{ Form::text('city', null, array('class' => 'form-control')) }}
                @if($errors->has('city'))
                <span class="help-block">{{ $errors->first('city') }}</span>
                @endif
            </div>
        </div>

        {{-- Country --}}
        <div class="form-group @if($errors->has('country'))has-error @endif">
            {{ Form::label('country', trans('validation.attributes.country')) }}
            {{ Form::text('country', null, array('class' => 'form-control')) }}
            @if($errors->has('country'))
            <span class="help-block">{{ $errors->first('country') }}</span>
            @endif
        </div>

        <div class="row">
            {{-- Phone --}}
            <div class="col-xs-6 form-group @if($errors->has('phone'))has-error @endif">
                {{ Form::label('phone', trans('validation.attributes.phone')) }}
                {{ Form::text('phone', null, array('class' => 'form-control')) }}
                @if($errors->has('phone'))
                <span class="help-block">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            {{-- Mobile --}}
            <div class="col-xs-6 form-group @if($errors->has('mobile'))has-error @endif">
                {{ Form::label('mobile', trans('validation.attributes.mobile')) }}
                {{ Form::text('mobile', null, array('class' => 'form-control')) }}
                @if($errors->has('mobile'))
                <span class="help-block">{{ $errors->first('mobile') }}</span>
                @endif
            </div>
        </div>

        {{-- Fax --}}
        <div class="form-group @if($errors->has('fax'))has-error @endif">
            {{ Form::label('fax', trans('validation.attributes.fax')) }}
            {{ Form::text('fax', null, array('class' => 'form-control')) }}
            @if($errors->has('fax'))
            <span class="help-block">{{ $errors->first('fax') }}</span>
            @endif
        </div>

    </div>

</div>
