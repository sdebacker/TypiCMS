@extends('pages.public.master')

@section('page')

    <div class="row">

        @if($sideMenu)
        <div class="col-sm-4">
            {{ $sideMenu }}
        </div>
        @endif

        <div class="col-sm-8">
            {{ $model->body }}
        </div>

    </div>

@stop
