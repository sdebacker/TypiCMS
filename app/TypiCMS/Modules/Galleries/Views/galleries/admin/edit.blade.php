@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.galleries.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('galleries.admin._form')
    {{ Form::close() }}

@stop
