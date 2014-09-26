@section('main')

<h1>{{ ucfirst(trans('global.settings')) }}</h1>

<div class="row">

    <div class="col-sm-6">

    {{ Form::model($data, array('method' => 'post', 'role' => 'form')) }}

        @include('settings.admin._form')

    {{ Form::close() }}

    </div>

    <div class="col-sm-6">

        <div>
            <a href="{{ route('backup') }}" class="btn btn-default"><i class="fa fa-download"></i> {{ trans('settings::global.Backup DB') }}</a>
            <a href="{{ route('cache.clear') }}" class="btn btn-default"><span class="fa fa-trash-o"></span> {{ trans('settings::global.Clear cache') }}</a>
        </div>

        <table class="table table-condensed">
            <thead>
                <tr><th colspan="2">@lang('settings::global.System info')</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-sm-6">@lang('settings::global.Environment')</td>
                    <td class="col-sm-6"><b>{{ App::environment(); }}</b></td>
                </tr>
                <tr>
                    <td>@lang('settings::global.System locales')</td>
                    <td>
                        <div class="max-height">
                            <b><?php try { system('locale -a'); } catch (Exception $e) { echo $e->getMessage(); } ?></b>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>@lang('settings::global.Active locale')</td>
                    <td><b>{{ Config::get('app.locale'); }}</b></td>
                </tr>
                <tr>
                    <td>@lang('settings::global.Cache')</td>
                    <td><b><?php echo Config::get('app.cache') ? trans('settings::global.Yes') : trans('settings::global.No') ; ?></b></td>
                </tr>
            </tbody>
        </table>

    </div>

</div>

@stop
