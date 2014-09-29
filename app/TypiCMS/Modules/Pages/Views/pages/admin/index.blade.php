@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('main')

    <h1>
        <a href="{{ route('admin.pages.create') }}" class=""><span class="fa fa-plus-circle"></span><span class="sr-only">{{ ucfirst(trans('pages::global.New')) }}</span></a>
        <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('pages::global.pages', $models->getTotal())
    </h1>
    
    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        <ul class="list-main nested sortable">
        @foreach ($models as $model)
            @include('pages.admin._listItem', array('model' => $model))
        @endforeach
        </ul>

    </div>

@stop
