@section('main')

<div class="row">

	<div id="register" class="container-login col-sm-4 col-sm-offset-4">

		<h1>Register New Account</h1>

		{{ Former::vertical_open()->role('form') }}

			{{ Former::lg_email()->label('Email')->required() }}

			<div class="row">
				<div class="col-lg-6">
				{{ Former::lg_text('first_name')->required() }}
				</div>
				<div class="col-lg-6">
				{{ Former::lg_text('last_name')->required() }}
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6">
				{{ Former::lg_password('password')->required()->autocomplete('off') }}
				</div>
				<div class="col-lg-6">
				{{ Former::lg_password('password_confirmation')->required()->autocomplete('off') }}
				</div>
			</div>

			{{ Former::lg_primary_block_button()->type('submit')->value('Register'); }}

		{{ Former::close() }}

	</div>

</div>

@stop