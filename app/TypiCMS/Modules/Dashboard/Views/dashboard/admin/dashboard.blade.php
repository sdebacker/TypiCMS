@section('breadcrumbs') @stop

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

    </div>

</div>

@stop
