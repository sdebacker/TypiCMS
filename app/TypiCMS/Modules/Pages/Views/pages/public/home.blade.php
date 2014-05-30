@extends('pages.public.master')

@section('page')

    <div class="row">

        <div class="col-sm-4">

            @if($sideMenu)
                {{ $sideMenu }}
            @endif

            @if($latestNews = News::latest(3))
            <h3>Latest news</h3>
            <ul>
                @foreach ($latestNews as $news)
                <li>
                    <strong>{{ $news->title }}</strong><br>
                    <span class="date">{{ $news->present()->dateLocalized }}</span>
                </li>
                @endforeach
            </ul>
            @endif

            @if($incomingEvents = Events::incoming())
            <h3>Incoming events</h3>
            <ul>
                @foreach ($incomingEvents as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    <span class="date">{{ $event->present()->dateFromTo }}</span>
                </li>
                @endforeach
            </ul>
            @endif

        </div>

        <div class="col-sm-8">
            {{ $model->body }}
        </div>

    </div>

@stop
