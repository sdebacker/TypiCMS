@extends('pages.public.master')

@section('page')

    <div class="row">

<div id="myCarousel" class="carousel slide">
   <!-- 轮播（Carousel）指标 -->
   <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
   </ol>   
   <!-- 轮播（Carousel）项目 -->
   <div class="carousel-inner">
      <div class="item active">
         <img src="/public/upload/1.jpg" alt="First slide">
         <div class="carousel-caption">标题 1</div>
      </div>
      <div class="item">
         <img src="/public/upload/2.jpg" alt="Second slide">
         <div class="carousel-caption">标题 2</div>
      </div>
      <div class="item">
         <img src="/public/img/3.jpg" alt="Third slide">
         <div class="carousel-caption">标题 3</div>
      </div>
      <div class="item active">
         <img src="/public/img/4.jpg" alt="First slide">
         <div class="carousel-caption">标题 4</div>
      </div>
      <div class="item active">
         <img src="/public/img/5.jpg" alt="First slide">
         <div class="carousel-caption">标题 5</div>
      </div>
   </div>
   <!-- 轮播（Carousel）导航 -->
   <a class="carousel-control left" href="#myCarousel" 
      data-slide="prev">&lsaquo;</a>
   <a class="carousel-control right" href="#myCarousel" 
      data-slide="next">&rsaquo;</a>
</div> 
        <div class="col-sm-4">

            @if($latestNews = News::latest(3) and $latestNews->count())
            <h3>@lang('db.Latest news')</h3>
            <ul>
                @foreach ($latestNews as $news)
                <li>
                    <strong><a href="{{ route($lang . '.news.slug', $news->slug) }}" class="btn btn-default btn-xs">{{ $news->title }}</a></strong><br>
<p>
<!--
                    <span class="date">{{ $news->present()->dateLocalized }}</span><br>
                    <a href="{{ route($lang . '.news.slug', $news->slug) }}" class="btn btn-default btn-xs">@lang('db.More')</a>
-->
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
                    <strong><a href="{{ route($lang . '.events.slug', $event->slug) }}" class="btn btn-default btn-xs">{{ $event->title }}</a></strong><br>
<p>
<!--
                    <span class="date">{{ $event->present()->dateFromTo }}</span><br>
                    <a href="{{ route($lang . '.events.slug', $event->slug) }}" class="btn btn-default btn-xs">@lang('db.More')</a>
-->
                </li>
                @endforeach
            </ul>
            <a href="{{ route($lang . '.events') }}" class="btn btn-default btn-xs">@lang('db.All events')</a>
            @endif

        </div>

<!--
        <div class="col-sm-8">
            {{ $model->body }}
            <div class="well">
                {{ Blocks::build('block1') }}
            </div>
        </div>
-->

    </div>

@stop
