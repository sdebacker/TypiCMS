<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => getenv('MAILGUN_DOMAIN'),
		'secret' => getenv('MAILGUN_SECRET'),
	),

	'mandrill' => array(
		'secret' => getenv('MANDRILL_SECRET'),
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => getenv('STRIPE_SECRET'),
	),

	'rollbar' => array(
		'access_token' => getenv('ROLLBAR_TOKEN'),
		'level' => 'debug'
	),

);
