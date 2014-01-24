<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ trans('modules.users.Welcome') }} {{ $firstName }} {{ $lastName }}</h2>

		<p><b>{{ trans('modules.users.Account:') }}</b> {{{ $email }}}</p>
		<p>{{ trans('modules.users.To activate your account') }}, <a href="{{  URL::route('activate', array($userId, urlencode($activationCode))) }}">{{ trans('modules.users.click here') }}.</a></p>
		<p>{{ trans('modules.users.Or point your browser to this address:') }} <br /> {{  URL::route('activate', array($userId, urlencode($activationCode))) }}</p>
		<p>{{ trans('modules.users.Thank you') }}</p>
	</body>
</html>