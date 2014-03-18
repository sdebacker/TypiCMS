@section('main')

    {{ Form::open( array( 'route' => array('admin.users.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('admin.users._form')
    {{ Form::close() }}

@stop
