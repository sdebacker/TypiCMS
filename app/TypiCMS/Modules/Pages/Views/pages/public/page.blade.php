
@section('head')
    @if($model->css)
    <style type="text/css">
        {{ $model->css }}
    </style>
    @endif
    @if($model->js)
    <script>
        {{ $model->js }}
    </script>
    @endif
@stop

@section('main')

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

    @include('files.public._list', array('files' => $model->files))

@stop
