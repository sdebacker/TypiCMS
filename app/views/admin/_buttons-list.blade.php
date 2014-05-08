        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group pull-right">
                @section('btn-locales')
                    @foreach (Config::get('app.locales') as $locale)
                        {{ Html::langButton($locale) }}
                    @endforeach
                @show
            </div>
        </div>
