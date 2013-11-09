<?php

$list = TypiCMS\Models\Setting::where('group_name', \Config::get('app.locale'))
	->orWhere('group_name', 'config')
	->lists('value','key_name');

return $list;
