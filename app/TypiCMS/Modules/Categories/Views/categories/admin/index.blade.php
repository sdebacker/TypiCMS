@section('js')
    {{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ count($models) }}</span> @choice('categories::global.categories', count($models))
@stop

@section('addButton')
    <a href="{{ route('admin.categories.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('categories::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        <ul class="list-main sortable">
        @foreach ($models as $model)
            <li id="item_{{ $model->id }}">
                <div>
                    {{ $model->checkbox }}
                    {{ $model->edit }}
                    {{ $model->status }}
                    {{ $model->title }}
                </div>
            </li>
        @endforeach
        </ul>

    </div>

@stop
