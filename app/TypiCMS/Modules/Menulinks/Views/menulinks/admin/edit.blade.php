@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.menus.menulinks.update', $model->menu_id, $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('menulinks.admin._form')
    {{ Form::close() }}

@stop
