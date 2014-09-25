@section('main')

    <h1>
        @include('admin._button-back', ['table' => $model->route])
        @lang('news::global.New')
    </h1>

    {{ Form::open( array( 'route' => array('admin.news.index'), 'method' => 'post', 'role' => 'form' ) ) }}
        @include('news.admin._form')
    {{ Form::close() }}

@stop
