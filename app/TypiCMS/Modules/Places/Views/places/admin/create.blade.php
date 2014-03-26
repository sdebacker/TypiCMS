@section('main')

    {{ Form::open( array( 'files' => true, 'route' => array('admin.places.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('places.admin._form')
    {{ Form::close() }}

@stop
