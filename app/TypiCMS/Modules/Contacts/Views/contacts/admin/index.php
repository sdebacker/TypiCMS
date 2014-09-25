@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('contacts::global.contacts', $models->getTotal())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.contacts.create') }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('contacts::global.New')) }}</span></a>
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
                        {{ Html::th('created_at', 'desc') }}
                        {{ Html::th('title') }}
                        {{ Html::th('first_name') }}
                        {{ Html::th('last_name') }}
                        {{ Html::th('email') }}
                        {{ Html::th('message') }}
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $model)

                    <tr id="item_{{ $model->id }}">
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->present()->edit }}</td>
                        <td>{{ $model->present()->createdAt }}</td>
                        <td>{{ $model->title }}</td>
                        <td>{{ $model->first_name }}</td>
                        <td>{{ $model->last_name }}</td>
                        <td>{{ $model->email }}</td>
                        <td>{{ $model->message }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
