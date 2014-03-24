@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.categories.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('categories.admin._form')
    {{ Form::close() }}

@stop
