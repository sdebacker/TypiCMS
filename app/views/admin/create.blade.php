@section('main')

    <h1>
        @include('admin._button-back', ['table' => $model->getTable()])
        @lang($model->getTable() . '::global.New')
    </h1>

    {{ Form::open( array( 'route' => array('admin.' . $model->getTable() . '.index'), 'files' => true, 'method' => 'post', 'role' => 'form' ) ) }}
        @include($model->getTable() . '.admin._form')
    {{ Form::close() }}

@stop
