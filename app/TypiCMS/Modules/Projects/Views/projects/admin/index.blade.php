@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->count() }}</span> @choice('projects::global.projects', $models->count())
@stop

@section('addButton')
    <a href="{{ route('admin.projects.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('projects::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        <ul class="list-main">
        @foreach ($models as $model)
            <li id="item_{{ $model->id }}">
                <div>
                    {{ $model->present()->checkbox }}
                    {{ $model->present()->edit }}
                    {{ $model->present()->status }}
                    <a href="{{ route('admin.projects.edit', $model->id) }}">{{ $model->title }}</a>
                </div>
            </li>
        @endforeach
        </ul>

    </div>

@stop
