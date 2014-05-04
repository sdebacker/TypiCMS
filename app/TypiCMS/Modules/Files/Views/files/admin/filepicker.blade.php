<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Choose file</title>

    {{ HTML::style(asset('css/admin.css')) }}

    <script>
        function selectAndClose(image) {
            var TinyMCEWindow = top.tinymce.activeEditor.windowManager;
            TinyMCEWindow.getParams().oninsert(image);
            TinyMCEWindow.close();
        }
    </script>

</head>

<body style="padding-top:15px">

    <div class="col-sm-12">
    @if (count($models))
        <div class="clearfix">
        @foreach ($models as $key => $model)
            <div class="thumbnail" onclick="selectAndClose('/{{ $model->path }}/{{ $model->filename }}')">
                {{ $model->present()->thumb }}
                <div class="caption">
                    <small>{{ $model->filename }}</small>
                    <div>{{ $model->alt_attribute }}</div>
                </div>
            </div>
        @endforeach
        </div>
        {{ $models->appends(Input::except('page'))->links() }}
    @else
        <p class="text-muted">@lang('global.No file')</p>
    @endif
    </div>

</body>

</html>
