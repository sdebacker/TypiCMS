<?php

return array(


	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => $_ENV['MYSQL_DATABASE'],
			'username'  => $_ENV['MYSQL_USERNAME'],
			'password'  => $_ENV['MYSQL_PASSWORD'],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'typi_',
		),

	),

);
