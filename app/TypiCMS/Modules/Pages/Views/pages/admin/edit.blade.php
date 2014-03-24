@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.pages.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('pages.admin._form')
    {{ Form::close() }}

@stop
