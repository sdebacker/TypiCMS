@section('head')
    {{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('addButton')
    <span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span>
@stop

@section('main')

    <div class="alert alert-info">
        @lang('files::global.files_edit_info').
    </div>

    @include('admin._buttons-list')

    <div class="clearfix">
    @foreach ($models as $key => $model)
        <span class="thumbnail @if($model->status == 1) online @else offline @endif" id="item_{{ $model->id }}">
            {{ $model->thumb }}
            <div class="caption">
                <small>{{ $model->status }} {{ $model->filename }}</small>
                <div>{{ $model->alt_attribute }}</div>
            </div>
        </span>
    @endforeach
    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop