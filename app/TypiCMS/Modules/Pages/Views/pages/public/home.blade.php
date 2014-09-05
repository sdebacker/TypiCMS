@extends('pages.public.master')

@section('page')

    <div class="row">

        <div class="col-sm-4">

            @if($latestNews = News::latest(3) and $latestNews->count())
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

            @if($incomingEvents = Events::incoming() and $incomingEvents->count())
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
            <div class="well">
                {{ Blocks::build('block1') }}
            </div>
        </div>

    </div>

@stop
