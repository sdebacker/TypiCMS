<?php
// filename: app/config/settings.php

$list = array();

$format = function(&$list, $keys, $val) use(&$format) {
    $keys ? $format($list[array_shift($keys)], $keys, $val) : $list = $val;
};

foreach(TypiCMS\Models\Setting::all() as $setting) {
    $format($list, explode('.', $setting->token), $setting->content);
}
d($list);
return $list;
