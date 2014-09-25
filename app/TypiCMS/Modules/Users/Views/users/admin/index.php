<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="{{ models.length }}" translate-plural="{{ models.length }} content blocks">{{ models.length }} content block</span>
    </h1>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="activated" class="activated st-sort" translate>Activated</th>
                    <th st-sort="first_name" class="first_name st-sort" translate>First name</th>
                    <th st-sort="last_name" class="last_name st-sort" translate>Last name</th>
                    <th st-sort="email" class="email st-sort" translate>Email</th>
                    <th st-sort="superuser" class="superuser st-sort" translate>Superuser</th>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="3">
                        <input st-search class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td typi-btn-activated></td>
                    <td>{{ model.first_name }}</td>
                    <td>{{ model.last_name }}</td>
                    <td>{{ model.email }}</td>
                    <td>{{ model.superuser }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->count() }}</span> @choice('users::global.users', $models->count())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.users.create') }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('users::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @section('btn-locales') @stop

        @include('admin._buttons-list')

        <div class="table-responsive">

            <table class="table table-condensed table-main">

                <thead>

                    <tr>
                        {{ Html::th('checkboxes', null, false, false) }}
                        {{ Html::th('edit', null, false, false) }}
                        {{ Html::th('name', null, false) }}
                        {{ Html::th('email', null, false) }}
                        {{ Html::th('isSuperUser', null, false) }}
                        {{ Html::th('status', null, false) }}
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $model)

                    <tr id="item_{{ $model->id }}">
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->present()->edit }}</td>
                        <td>{{ $model->first_name }} {{ $model->last_name }}</td>
                        <td><a href="mailto:{{ $model->email }}">{{ $model->email }}</a></td>
                        <td>{{ $model->present()->superuser }}</td>
                        <td>{{ $model->status }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@stop
