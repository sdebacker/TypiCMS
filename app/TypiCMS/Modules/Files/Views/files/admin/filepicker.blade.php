@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
    <script>
        function selectAndClose(image) {
            var TinyMCEWindow = top.tinymce.activeEditor.windowManager;
            TinyMCEWindow.getParams().oninsert(image);
            TinyMCEWindow.close();
        }
    </script>
@stop

@section('bodyClass')
@stop
@section('navbar')
@stop
@section('sidebar')
@stop
@section('mainClass')
col-xs-12
@stop
@section('breadcrumbs')
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('titleLeftButton')
@stop

@section('main')

    @include('files.admin.thumbnails')

@stop
