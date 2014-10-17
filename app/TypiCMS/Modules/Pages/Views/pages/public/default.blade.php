@extends('pages.public.master')

@section('page')

    <div class="row">

        @if($children)
        <div class="col-sm-4">
            <ul class="list-main nested sortable">
            @foreach ($children as $child)
                @include('pages.public._listItem', array('child' => $child))
            @endforeach
            </ul>
        </div>
        @endif


        <div class="col-sm-8">
            {{ $model->body }}
            @include('galleries.public._galleries')
        </div>

    </div>

@stop
