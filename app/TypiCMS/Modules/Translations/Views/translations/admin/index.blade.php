@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->count() }}</span> @choice('translations::global.translations', $models->count())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.translations.create') }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('translations::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @section('btn-locales') @stop
        @include('admin._buttons-list')

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>
                        {{ Html::th('checkboxes', null, false, false) }}
                        {{ Html::th('key', 'asc') }}
                        @foreach (Config::get('app.locales') as $locale)
                            <th>@lang('global.languages.' . $locale)</th>
                        @endforeach
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $item)

                    <tr id="item_{{ $item['id'] }}">
                        <td><input type="checkbox" value="{{ $item['id'] }}"></td>
                        <td contenteditable data-name="key">{{ $item['key'] }}</td>
                        @foreach (Config::get('app.locales') as $locale)
                            <td contenteditable data-name="{{ $locale }}[translation]">{{ $item[$locale] or '' }}</td>
                        @endforeach
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@stop
