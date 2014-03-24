@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.menus.update', $model->id), 'method' => 'patch', 'role' => 'form') ) }}
        @include('menus.admin._form')
    {{ Form::close() }}

@stop
