<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('modules.users.Reset password')</h2>

		<div>
			@lang('To reset your password, complete this form:') {{ URL::route('resetpassword', array($token)) }}.
		</div>
	</body>
</html>