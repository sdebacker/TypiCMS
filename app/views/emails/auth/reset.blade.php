<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('modules.users.Reset password')</h2>

		<p>{{ trans('modules.users.To reset your password') }}, <a href="{{ URL::route('changepassword', array('id' => $userId, urlencode($resetCode))) }}">{{ trans('modules.users.click here') }}.</a></p>
		<p>{{ trans('modules.users.Or point your browser to this address:') }} <br /> {{  URL::route('changepassword', array('id' => $userId, urlencode($resetCode))) }}</p>
		<p>{{ trans('modules.users.Thank you') }}</p>
	</body>
</html>