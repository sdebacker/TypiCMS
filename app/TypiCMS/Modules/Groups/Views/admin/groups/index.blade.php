@section('js')
    {{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ count($models) }}</span> @choice('groups::global.groups', count($models))
@stop

@section('addButton')
    <a href="{{ route('admin.groups.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('users::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @section('btn-locales') @stop

        @include('admin._buttons-list')

        <div class="table-responsive">

            <table class="table table-condensed table-main">

                <thead>
                    {{ Html::th('checkboxes', null, false, false) }}
                    {{ Html::th('edit', null, false, false) }}
                    {{ Html::th('name', null, false) }}
                    {{ Html::th('permissions', null, false) }}
                </thead>

                <tbody>

                    @foreach ($models as $model)

                    <tr id="item_{{ $model->id }}">
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->present()->edit }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ implode(', ', array_keys($model['permissions'])) }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@stop
