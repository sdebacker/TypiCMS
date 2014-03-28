@section('main')

    {{ Form::model( $model->object, array( 'route' => array('admin.contacts.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}

        @include('contacts.admin._form')

    {{ Form::close() }}

@stop
