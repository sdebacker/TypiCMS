@section('main')

    {{ Form::open( array( 'route' => array('admin.translations.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('translations.admin._form')
    {{ Form::close() }}

@stop
