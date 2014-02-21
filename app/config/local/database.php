<?php

return array(


	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => getenv('MYSQL_DATABASE'),
			'username'  => getenv('MYSQL_USERNAME'),
			'password'  => getenv('MYSQL_PASSWORD'),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'typi_',
		),

	),

);
