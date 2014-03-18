@section('main')

    {{ Form::open( array( 'route' => array('admin.menus.menulinks.index', $menu->id), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('menulinks.admin._form')
    {{ Form::close() }}

@stop
