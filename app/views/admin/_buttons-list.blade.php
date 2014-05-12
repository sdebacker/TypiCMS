        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group pull-right">
                @section('btn-locales')
                    @if (count(Config::get('app.locales')) > 1)
                        @foreach (Config::get('app.locales') as $locale)
                            {{ Html::langButton($locale) }}
                        @endforeach
                    @endif
                @show
            </div>
        </div>
