<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<p>To reset your password, <a href="{{ URL::route('changepassword', array('id' => $userId, urlencode($resetCode))) }}">click here.</a></p>
		<p>Or point your browser to this address: <br /> {{  URL::route('changepassword', array('id' => $userId, urlencode($resetCode))) }}</p>
		<p>Thank you, <br />
		The Typi Team</p>
	</body>
</html>