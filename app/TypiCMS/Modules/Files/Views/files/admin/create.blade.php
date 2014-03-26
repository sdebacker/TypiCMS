@section('main')

    {{ Form::open( array( 'files' => true, 'route' => array('admin.' . $parent->route . '.files.index', $parent->id), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('files.admin._form')
    {{ Form::close() }}

@stop
