@section('main')

    {{ Form::model( $group, array( 'route' => array('admin.groups.update', $group->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('admin.groups._form')
    {{ Form::close() }}

@stop
