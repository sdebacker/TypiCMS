@section('main')

    {{ Form::open( array( 'route' => array('admin.projects.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('projects.admin._form')
    {{ Form::close() }}

@stop