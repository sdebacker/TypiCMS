@section('main')

    <h2>{{ $model->title }}</h2>
    <img src="{{ $model->logo->url('md') }}" alt="">
    <p>{{ $model->url }}</p>
    <div>{{ $model->body }}</div>

@stop
