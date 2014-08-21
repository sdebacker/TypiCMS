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
