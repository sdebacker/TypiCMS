@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.' . $parent->route . '.files.update', $model->fileable_id, $model->id), 'files' => true, 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('files.admin._form')
    {{ Form::close() }}

@stop
