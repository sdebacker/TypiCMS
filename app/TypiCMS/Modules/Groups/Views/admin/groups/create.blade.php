@section('main')

    {{ Form::open(array( 'route' => array('admin.groups.store'))) }}
        @include('admin.groups._form')
    {{ Form::close() }}

@stop
