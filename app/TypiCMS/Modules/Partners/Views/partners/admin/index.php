@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('partners::global.partners', $models->getTotal())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.partners.create') }}" class="btn-add"><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('partners::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form">

        @include('admin._buttons-list')

        <div class="table-responsive">

            <table class="table table-condensed table-main">

                <thead>

                    <tr>
                        {{ Html::th('checkboxes', null, false, false) }}
                        {{ Html::th('edit', null, false, false) }}
                        {{ Html::th('status', null, false) }}
                        {{ Html::th('logo', null, false) }}
                        {{ Html::th('title', null, false) }}
                        {{ Html::th('website', null, false) }}
                    </tr>

                </thead>

                <tbody>

                    @foreach ($models as $model)

                    <tr id="item_{{ $model->id }}">
                        <td>{{ $model->present()->checkbox }}</td>
                        <td>{{ $model->present()->edit }}</td>
                        <td>{{ $model->present()->status }}</td>
                        <td>{{ $model->present()->thumb(null, 24, array(), 'logo') }}</td>
                        <td>{{ $model->title }}</td>
                        <td><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
