@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.events.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('events.admin._form')
    {{ Form::close() }}

@stop
