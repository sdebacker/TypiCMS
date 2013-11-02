@section('main')

<div class="row">

	<div id="login" class="container-login col-sm-4 col-sm-offset-4">

		<h1>{{ trans('users.New password') }}</h1>

		{{ Former::vertical_open()->role('form'); }}

		<div class="row">
			<div class="col-lg-6">
			{{ Former::lg_password('password')->autocomplete('off'); }}
			</div>
			<div class="col-lg-6">
			{{ Former::lg_password('password_confirmation')->autocomplete('off'); }}
			</div>
		</div>

		{{ Former::hidden('resetCode', $resetCode);  }}

		{{ Former::hidden('id', $id); }}

		{{ Former::lg_primary_block_button()->type('submit')->value('save'); }}

		{{ Former::close(); }}

	</div>

</div>
@stop