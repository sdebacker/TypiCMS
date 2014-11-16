@section('main')

    <h1>
        @include('admin._button-back', ['table' => $model->getTable()])
        {{ $model->present()->title }}
    </h1>

    {{ Form::model( $model, array( 'route' => array('admin.' . $model->getTable() . '.update', $model->id), 'files' => true, 'method' => 'put', 'role' => 'form' ) ) }}
        @include($model->getTable() . '.admin._form')
    {{ Form::close() }}

@stop
