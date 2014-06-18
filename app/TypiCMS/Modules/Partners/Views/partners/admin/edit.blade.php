@section('main')

    {{ Form::model( $model, array( 'files' => true, 'route' => array('admin.partners.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('partners.admin._form')
    {{ Form::close() }}

@stop
