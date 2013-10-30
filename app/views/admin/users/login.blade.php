@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		{{ Former::open_vertical()->role('form') }}

			{{ Former::lg_text('email')->label('')->placeholder('Email') }}

			{{ Former::lg_password('password')->label('')->placeholder('Password')->help(link_to('users/resetpassword', trans('users.Forgot your password?'))) }}

			{{ Former::lg_primary_block_button()->type('submit')->value('Log In'); }}

		{{ Former::close() }}
		
	</div>

</div>

@stop