    @foreach ($model->galleries as $gallery)
    <div class="slider clearfix">
        <ul class="slides">
            @foreach ($gallery->files as $file)
            <li>
                <a class="fancybox" href="/{{ $file->path . $file->filename }}" title="{{ $file->description }}" rel="{{ $gallery->name }}" title="{{{ $file->description }}}">
                    <img class="img-responsive" src="{{ Croppa::url('/' . $file->path . $file->filename, 519, 350) }}" alt="{{ $file->alt_attribute }}">
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
