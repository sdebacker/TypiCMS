@section('main')

    <h1>
        <a href="{{ route('admin.menus.edit', $menu->id) }}" title="{{ trans('menulinks::global.Back') }}">
            <span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ trans('menulinks::global.Back') }}</span>
        </a>
        {{ $model->present()->title }}
    </h1>

    {{ Form::model( $model, array( 'route' => array('admin.menus.menulinks.update', $menu->id, $model->id), 'files' => true, 'method' => 'put', 'role' => 'form' ) ) }}
        @include('menulinks.admin._form')
    {{ Form::close() }}

@stop
