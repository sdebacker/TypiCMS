<?php
$config = array();
foreach (DB::table('settings')->get() as $object) {
	$key = $object->key_name;
	if ($object->group_name != 'config') {
		$config[$object->group_name][$key] = $object->value;
	} else {
		$config[$key] = $object->value;
	}
}
return $config;
