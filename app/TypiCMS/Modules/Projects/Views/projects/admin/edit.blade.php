@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.projects.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('projects.admin._form')
    {{ Form::close() }}

@stop
