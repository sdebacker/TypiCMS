@section('main')

    {{ Form::open( array( 'route' => array('admin.categories.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('categories.admin._form')
    {{ Form::close() }}

@stop
