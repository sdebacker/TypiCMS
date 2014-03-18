@section('main')

    {{ Form::model( $user, array( 'route' => array('admin.users.update', $user->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('admin.users._form')
    {{ Form::close() }}

@stop
