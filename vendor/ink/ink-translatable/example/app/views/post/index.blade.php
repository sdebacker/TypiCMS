@foreach($records as $record)
    <p>{{ $record->title }} - <a href="/posts/{{ $record->id }}/edit">edit</a> | <a href="/posts/{{ $record->id }}/delete">delete</a></p>
@endforeach