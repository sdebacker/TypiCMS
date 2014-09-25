@section('main')

    <h1>
        @include('admin._button-back', ['table' => $model->getTable()])
        @lang($module . '::global.New')
    </h1>

    {{ Form::open( array( 'route' => array('admin.' . $route . '.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include($module . '.admin._form')
    {{ Form::close() }}

@stop
