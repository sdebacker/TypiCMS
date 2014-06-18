@extends('pages.public.master')

@section('page')

    <div class="row">

        <div class="col-sm-4">

            @if($latestNews = News::latest(3))
            <h3>@lang('db.Latest news')</h3>
            <ul>
                @foreach ($latestNews as $news)
                <li>
                    <strong>{{ $news->title }}</strong><br>
                    <span class="date">{{ $news->present()->dateLocalized }}</span><br>
                    <a href="{{ route($lang . '.news.slug', $news->slug) }}" class="btn btn-default btn-xs">@lang('db.More')</a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route($lang . '.news') }}" class="btn btn-default btn-xs">@lang('db.All news')</a>
            @endif

            @if($incomingEvents = Events::incoming())
            <h3>@lang('db.Incoming events')</h3>
            <ul>
                @foreach ($incomingEvents as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    <span class="date">{{ $event->present()->dateFromTo }}</span><br>
                    <a href="{{ route($lang . '.events.slug', $event->slug) }}" class="btn btn-default btn-xs">@lang('db.More')</a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route($lang . '.events') }}" class="btn btn-default btn-xs">@lang('db.All events')</a>
            @endif

        </div>

        <div class="col-sm-8">
            {{ $model->body }}
        </div>

    </div>

    <div class="partners">
        @if($partners = Partners::getAll())
        <h3>
            <a href="{{ route($lang . '.partners') }}">@lang('db.Partners')</a>
        </h3>
        <ul>
            @foreach ($partners as $partner)
            <li>
                <img src="{{ $partner->present()->thumb(null, null, array(), 'logo') }}" alt="">
                <a href="{{ $partner->website }}" target="_blank">{{ $partner->title }}</a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

@stop
