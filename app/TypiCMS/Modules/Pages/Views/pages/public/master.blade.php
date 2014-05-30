@section('css')
    @if($model->css)
    <style type="text/css">
        {{ $model->css }}
    </style>
    @endif
@stop

@section('js')
    @if($model->js)
    <script>
        {{ $model->js }}
    </script>
    @endif
@stop

@section('main')

    @yield('page')

@stop
