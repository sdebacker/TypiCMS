@section('main')

    <h1>
        @include('admin._button-back', ['table' => $model->route])
        {{ $model->title }}
    </h1>

    {{ Form::model( $model, array( 'route' => array('admin.news.update', $model->id), 'method' => 'put', 'role' => 'form' ) ) }}
        @include('news.admin._form')
    {{ Form::close() }}

@stop
