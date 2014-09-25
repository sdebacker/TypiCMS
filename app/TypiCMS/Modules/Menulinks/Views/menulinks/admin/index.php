@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('menulinks::global.menulinks', $models->getTotal())
@stop

@section('titleLeftButton')
    <a href="{{ route('admin.menus.menulinks.create', $menu->id) }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('menulinks::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        <ul class="list-main nested sortable">
        @foreach ($models as $model)
            @include('menulinks.admin._listItem', array('model' => $model))
        @endforeach
        </ul>

    </div>

@stop
