@section('js')
    {{ HTML::script(asset('js/admin/list-angular.js')) }}
@stop

@section('page-header')
@stop

@section('main')

@include('news.admin.list')

@stop
