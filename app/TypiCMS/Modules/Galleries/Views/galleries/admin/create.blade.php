@section('main')

    {{ Form::open( array( 'route' => array('admin.galleries.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('galleries.admin._form')
    {{ Form::close() }}

@stop
