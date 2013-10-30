<p>{{ Form::label('az[title]', 'Title AZ') }} : {{ Form::text('az[title]', isset($record->az->title) ? $record->az->title : '') }}</p>

<p>{{ Form::label('ru[title]', 'Title RU') }} : {{ Form::text('ru[title]', isset($record->ru->title) ? $record->ru->title : '') }}</p>

<p>{{ Form::label('en[title]', 'Title EN') }} : {{ Form::text('en[title]', isset($record->en->title) ? $record->en->title : '') }}</p>

<p>{{ Form::submit('Save') }}</p>