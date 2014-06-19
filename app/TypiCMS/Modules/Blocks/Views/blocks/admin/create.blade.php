@section('main')

    {{ Form::open( array( 'files' => true, 'route' => array('admin.blocks.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('blocks.admin._form')
    {{ Form::close() }}

@stop
