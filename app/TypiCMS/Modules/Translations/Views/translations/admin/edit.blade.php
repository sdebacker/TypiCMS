@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.translations.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
        @include('translations.admin._form')
    {{ Form::close() }}

@stop
