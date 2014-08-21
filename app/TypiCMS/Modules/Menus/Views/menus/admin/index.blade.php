@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->count() }}</span> @choice('menus::global.menus', $models->count())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.menus.create') }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('menus::global.New')) }}</span></a>
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
                    <a href="{{ route('admin.menus.menulinks.index', $model->id) }}">{{ $model->title }} ({{ $model->name }})</a>
                </div>
            </li>
        @endforeach
        </ul>

    </div>

@stop
