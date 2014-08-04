        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group" id="selectAllGroup">
                <a class="btn btn-default btn-xs" id="btn-select-all" href="#" data-deselect-text="{{ trans('global.Deselect all') }}">{{ trans('global.Select all') }}</a>
            </div>
            <div class="btn-group">
                <button class="btn btn-default btn-xs custom-alert" id="btnOnline" disabled="">{{ trans('global.Online') }}</button>
                <button class="btn btn-default btn-xs custom-alert" id="btnOffline" disabled="">{{ trans('global.Offline') }}</button>
            </div>
            <div class="btn-group">
                <button class="btn btn-danger btn-xs custom-alert" id="btnDelete" disabled="">{{ trans('global.Delete') }}</button>
            </div>
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
