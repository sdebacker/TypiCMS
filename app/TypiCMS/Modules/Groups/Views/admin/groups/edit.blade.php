@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.groups.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('admin.groups._form')
    {{ Form::close() }}

@stop
