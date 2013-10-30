{{ Form::open(array('url' => 'posts/'.$record->id, 'method' => 'put')) }}

    @include('post._form')

{{ Form::close() }}