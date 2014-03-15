@section('main')

    {{ Form::open( array( 'route' => array('admin.menus.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('menus.admin._form')
    {{ Form::close() }}

@stop