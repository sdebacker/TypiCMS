@section('main')

    <h2>{{ Str::title(trans_choice('contacts::global.contacts', 1)) }}</h2>

    @if ($formIsSent)
        <div class="jubotron alert alert-success text-center">
            <h1>@lang('db.message when contact form is sent')</h1>
        </div>
    @else

    @if($errors->first())
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @lang('db.message when errors in form')
        </div>
    @endif

    {{ Form::open( array( 'route' => array('contacts.index'), 'method' => 'post', 'role' => 'form' ) ) }}

        {{ Form::hidden('locale', App::getLocale()); }}
        {{ Form::hidden('language', App::getLocale()) }}
        
        {{ Form::honeypot('my_name', 'my_time') }}
        
        <div class="row">

            {{-- Title --}}
            <div class="col-sm-2 form-group @if($errors->has('title'))has-error @endif">
                <span class="fa fa-asterisk"></span>
                {{ Form::label('title', trans('validation.attributes.title')) }}
                {{ Form::select('title', array('' => '', 'mr' => trans('validation.attributes.mr'), 'mrs' => trans('validation.attributes.mrs')), null, array('class' => 'input-lg form-control')) }}
                @if($errors->has('title'))
                <span class="help-block">{{ $errors->first('title') }}</span>
                @endif
            </div>

            {{-- First name --}}
            <div class="col-sm-5 form-group @if($errors->has('first_name'))has-error @endif">
                <span class="fa fa-asterisk"></span>
                {{ Form::label('first_name', trans('validation.attributes.first_name')) }}
                {{ Form::text('first_name', null, array('class' => 'input-lg form-control')) }}
                @if($errors->has('first_name'))
                <span class="help-block">{{ $errors->first('first_name') }}</span>
                @endif
            </div>

            {{-- Last name --}}
            <div class="col-sm-5 form-group @if($errors->has('last_name'))has-error @endif">
                <span class="fa fa-asterisk"></span>
                {{ Form::label('last_name', trans('validation.attributes.last_name')) }}
                {{ Form::text('last_name', null, array('class' => 'input-lg form-control')) }}
                @if($errors->has('last_name'))
                <span class="help-block">{{ $errors->first('last_name') }}</span>
                @endif
            </div>

        </div>

        {{-- Email --}}
        <div class="form-group @if($errors->has('email'))has-error @endif">
            <span class="fa fa-asterisk"></span>
            {{ Form::label('email', trans('validation.attributes.email')) }}
            {{ Form::text('email', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('email'))
            <span class="help-block">{{ $errors->first('email') }}</span>
            @endif
        </div>

        {{-- Website --}}
        {{-- <div class="form-group @if($errors->has('website'))has-error @endif">
            {{ Form::label('website', trans('validation.attributes.website')) }}
            {{ Form::text('website', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('website'))
            <span class="help-block">{{ $errors->first('website') }}</span>
            @endif
        </div> --}}

        {{-- Company --}}
        {{-- <div class="form-group @if($errors->has('company'))has-error @endif">
            {{ Form::label('company', trans('validation.attributes.company')) }}
            {{ Form::text('company', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('company'))
            <span class="help-block">{{ $errors->first('company') }}</span>
            @endif
        </div> --}}

        {{-- Address --}}
        {{-- <div class="form-group @if($errors->has('address'))has-error @endif">
            {{ Form::label('address', trans('validation.attributes.address')) }}
            {{ Form::text('address', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('address'))
            <span class="help-block">{{ $errors->first('address') }}</span>
            @endif
        </div> --}}

        {{-- Postcode --}}
        {{-- <div class="form-group @if($errors->has('postcode'))has-error @endif">
            {{ Form::label('postcode', trans('validation.attributes.postcode')) }}
            {{ Form::text('postcode', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('postcode'))
            <span class="help-block">{{ $errors->first('postcode') }}</span>
            @endif
        </div> --}}

        {{-- City --}}
        {{-- <div class="form-group @if($errors->has('city'))has-error @endif">
            {{ Form::label('city', trans('validation.attributes.city')) }}
            {{ Form::text('city', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('city'))
            <span class="help-block">{{ $errors->first('city') }}</span>
            @endif
        </div> --}}

        {{-- Country --}}
        {{-- <div class="form-group @if($errors->has('country'))has-error @endif">
            {{ Form::label('country', trans('validation.attributes.country')) }}
            {{ Form::text('country', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('country'))
            <span class="help-block">{{ $errors->first('country') }}</span>
            @endif
        </div> --}}

        {{-- Phone --}}
        {{-- <div class="form-group @if($errors->has('phone'))has-error @endif">
            {{ Form::label('phone', trans('validation.attributes.phone')) }}
            {{ Form::text('phone', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('phone'))
            <span class="help-block">{{ $errors->first('phone') }}</span>
            @endif
        </div> --}}

        {{-- Mobile --}}
        {{-- <div class="form-group @if($errors->has('mobile'))has-error @endif">
            {{ Form::label('mobile', trans('validation.attributes.mobile')) }}
            {{ Form::text('mobile', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('mobile'))
            <span class="help-block">{{ $errors->first('mobile') }}</span>
            @endif
        </div> --}}

        {{-- Fax --}}
        {{-- <div class="form-group @if($errors->has('fax'))has-error @endif">
            {{ Form::label('fax', trans('validation.attributes.fax')) }}
            {{ Form::text('fax', null, array('class' => 'input-lg form-control')) }}
            @if($errors->has('fax'))
            <span class="help-block">{{ $errors->first('fax') }}</span>
            @endif
        </div> --}}

        {{-- Message --}}
        <div class="form-group @if($errors->has('message'))has-error @endif">
            <span class="fa fa-asterisk"></span>
            {{ Form::label('message', trans('validation.attributes.message')) }}
            {{ Form::textarea('message', null, array('class' => 'input-lg form-control', 'rows' => 5)) }}
            @if($errors->has('message'))
            <span class="help-block">{{ $errors->first('message') }}</span>
            @endif
        </div>

        <div class="form-group">
            <span class="fa fa-asterisk"></span> {{ trans('global.Mandatory fields') }}
        </div>

        <button class="btn-primary btn btn-block btn-lg" type="submit">@lang('validation.attributes.send')</button>

    {{ Form::close() }}
    
    @endif

@stop
