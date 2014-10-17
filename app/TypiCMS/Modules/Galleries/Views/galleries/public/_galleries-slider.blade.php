@foreach ($model->galleries as $gallery)
    @if($gallery->title)
    <h3>{{ $gallery->title }}</h3>
    @endif
    {{ $gallery->body }}
    @include('galleries.public._slider', ['model' => $gallery])
@endforeach
