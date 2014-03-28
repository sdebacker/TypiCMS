@section('main')

    {{ Form::open( array( 'route' => array('admin.contacts.index'), 'method' => 'post', 'role' => 'form' ) ) }}

        @include('contacts.admin._form')

    {{ Form::close() }}

@stop
