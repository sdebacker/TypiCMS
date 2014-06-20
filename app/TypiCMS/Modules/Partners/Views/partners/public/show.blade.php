@section('main')

    <h2>{{ $model->title }}</h2>
    {{ $model->present()->thumb(null, 200, array(), 'logo') }}
    <p><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></p>
    <div>{{ $model->body }}</div>

@stop
