@section('page-header')
<div class="col-sm-4 col-sm-offset-4">
    @parent
</div>
@stop

@section('main')

    <p>{{ $model->title }}</p>

@stop