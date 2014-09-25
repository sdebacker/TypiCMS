@section('main')

    {{ Form::model( $model, array( 'route' => array('admin.pages.update', $model->id), 'method' => 'put', 'role' => 'form' ) ) }}
        @include('pages.admin._form')
    {{ Form::close() }}

@stop
