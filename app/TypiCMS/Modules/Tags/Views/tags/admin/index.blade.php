@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('main')

    <h1>
        <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('tags::global.tags', $models->getTotal())
    </h1>

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        <div class="table-responsive">

            <table class="table table-condensed table-main">

                <thead>

                    <tr>
                        {{ Html::th('checkboxes', null, false, false) }}
                        {{ Html::th('tag', 'asc') }}
                        {{ Html::th('uses') }}
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $model)

                    <tr id="item_{{ $model->id }}">
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->tag }}</td>
                        <td>{{ $model->uses }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
