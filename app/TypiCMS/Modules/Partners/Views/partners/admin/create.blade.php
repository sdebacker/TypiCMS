@section('main')

    {{ Form::open( array( 'files' => true, 'route' => array('admin.partners.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('partners.admin._form')
    {{ Form::close() }}

@stop
