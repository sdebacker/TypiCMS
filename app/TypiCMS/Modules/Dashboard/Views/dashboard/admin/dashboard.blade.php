@section('h1') @stop

@section('main')

<div class="row">

    <div class="col-sm-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h2 class="panel-title">@lang('dashboard::global.Welcome, :name!', array('name' => Sentry::getUser()->first_name))</h2>
            </div>

            <div class="panel-body">
                {{ $welcomeMessage }}
            </div>

        </div>

        @if($history = History::latest(20, ['user']) and $history->count())
        <h2>{{ ucfirst(trans('history::global.name')) }}</h3>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>@lang('global.Date')</th>
                    <th>@lang('global.Email')</th>
                    <th>@lang('global.Action')</th>
                    <th>@lang('global.Resource')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $item)
                <tr>
                    <td class="date">{{ $item->created_at }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->action }}</td>
                    <td><a href=""> HREF {{ $item->historable->present()->title }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

</div>

@stop
