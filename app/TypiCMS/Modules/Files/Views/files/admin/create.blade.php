@section('main')

    {{ Form::open( array( 'route' => array('admin.' . $parent->route . '.files.index', $parent->id), 'files' => true, 'method' => 'post', 'role' => 'form' ) ) }}
        @include('files.admin._form')
    {{ Form::close() }}

@stop
