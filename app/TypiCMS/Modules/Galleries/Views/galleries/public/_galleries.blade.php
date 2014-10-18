    @foreach ($model->galleries as $gallery)
    <div class="gallery">
        @if($gallery->title)
        <h3>{{ $gallery->title }}</h3>
        @endif
        {{ $gallery->body }}
        @include('galleries.public._thumbs', ['model' => $gallery])
    </div>
    @endforeach
