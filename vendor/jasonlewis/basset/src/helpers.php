<?php

if ( ! function_exists('basset_stylesheets'))
{
    /**
     * Ouput the stylesheets for several collections.
     * 
     * @return string
     */
    function basset_stylesheets()
    {
        $c = array(); $a = func_get_args();

        array_walk_recursive($a, function($v, $k) use (&$c) { is_numeric($k) ? ($c["{$v}.css"] = null) : ($c["{$k}.css"] = $v); });

        return basset_assets($c);
    }
}

if ( ! function_exists('basset_javascripts'))
{
    /**
     * Ouput the javascripts for several collections.
     * 
     * @return string
     */
    function basset_javascripts()
    {
        $c = array(); $a = func_get_args();

        array_walk_recursive($a, function($v, $k) use (&$c) { is_numeric($k) ? ($c["{$v}.js"] = null) : ($c["{$k}.js"] = $v); });

        return basset_assets($c);
    }
}

if ( ! function_exists('basset_assets'))
{
    /**
     * Output the assets for a collection as defined by the extension.
     * 
     * @return string
     */
    function basset_assets()
    {
        $collections = $responses = array(); $args = func_get_args();

        // If no arguments were supplied get all the collections and add both the stylesheet and javascript
        // flavors as arguments.
        if (empty($args))
        {
            foreach (app('basset')->all() as $identifier => $collection) $args[] = array("{$identifier}.css", "{$identifier}.js");
        }

        array_walk_recursive($args, function($v, $k) use (&$collections) { is_numeric($k) ? ($collections[$v] = null) : ($collections[$k] = $v); });

        foreach ($collections as $collection => $format) $responses[] = app('basset.server')->collection($collection, $format);

        return array_to_newlines($responses);
    }
}

if ( ! function_exists('array_to_newlines'))
{
    /**
     * Convert an array to a newline separated string.
     * 
     * @param  array  $array
     * @return string
     */
    function array_to_newlines(array $array)
    {
        return implode(PHP_EOL, $array);
    }
}