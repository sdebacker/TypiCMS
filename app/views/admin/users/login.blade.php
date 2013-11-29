@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		{{ Former::open_vertical()->role('form') }}

			{{ Former::lg_text('email')->label('')->placeholder('email')->autofocus() }}

			{{ Former::lg_password('password')->label('')->placeholder('password')->help(link_to_route('resetpassword', trans('users.Forgot your password?'))) }}

			{{ Former::lg_primary_block_button()->type('submit')->value('log in'); }}

		{{ Former::close() }}
		
	</div>

</div>

@stop