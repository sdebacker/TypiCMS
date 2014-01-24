<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('modules.users.Welcome') {{ $firstName }} {{ $lastName }}</h2>

		<p><b>Account:</b> {{{ $email }}}</p>
		<p>@lang('To activate your account'), <a href="{{  URL::route('activate', array($userId, urlencode($activationCode))) }}">@lang('click here').</a></p>
		<p>@lang('Or point your browser to this address:') <br /> {{  URL::route('activate', array($userId, urlencode($activationCode))) }}</p>
		<p>@lang('Thank you')</p>
	</body>
</html>