@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.places.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('places.admin._form')
    {{ Form::close() }}

@stop
