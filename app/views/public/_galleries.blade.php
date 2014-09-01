    @foreach ($model->galleries as $gallery)
    <div class="gallery">
        @if($gallery->title)
        <h3>{{ $gallery->title }}</h3>
        @endif
        {{ $gallery->body }}
        <div class="row">
            <ul class="list-unstyled">
                @foreach ($gallery->files as $file)
                <li class="col-xs-4 col-sm-3 col-md-2">
                    @if ($file->type == 'i')
                    <a class="thumbnail fancybox" href="/{{ $file->path . $file->filename }}" title="{{ $file->description }}" rel="{{ $gallery->name }}">
                        <img src="{{ Croppa::url('/' . $file->path . $file->filename, 400, 400) }}" width="200" height="200" alt="{{ $file->alt_attribute }}">
                    </a>
                    @else
                    <a href="/{{ $file->path . $file->filename }}">{{ $file->filename }}</a>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
