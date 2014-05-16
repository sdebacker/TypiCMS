@if (count(Config::get('app.locales')) > 1)
    @foreach (Config::get('app.locales') as $locale)
        {{ Html::langButton($locale) }}
    @endforeach
@endif
