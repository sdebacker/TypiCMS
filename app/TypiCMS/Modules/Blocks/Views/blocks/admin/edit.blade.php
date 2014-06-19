@section('main')

    {{ Form::model( $model, array( 'files' => true, 'route' => array('admin.blocks.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('blocks.admin._form')
    {{ Form::close() }}

@stop
