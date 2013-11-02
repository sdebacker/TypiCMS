@extends('admin/master')

@section('main')

<div class="row">
	
	<div id="reset" class="container-reset col-sm-4 col-sm-offset-4">

		{{ Former::open_vertical()->role('form') }}

			{{ Former::lg_text('email')->placeholder('email')->label('') }}

			{{ Former::lg_primary_block_button()->type('submit')->value('reset password') }}

		{{ Former::close() }}
		
	</div>

</div>


@stop