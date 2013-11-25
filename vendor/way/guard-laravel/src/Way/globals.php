<?php

if ( ! function_exists('stylesheet'))
{
	/**
	 * Generates the necessary HTML for a
	 * stylesheet link. Path should be relative
	 * to the css_path config option for Guard.
	 *
	 * @param  string $path
	 * @return string
	 */
	function stylesheet($path = 'styles.min.css')
	{
		$publicDirName = basename(public_path());

		$path = \Config::get('guard-laravel::guard.css_path') . "/$path";
		$path = str_replace($publicDirName, '', $path);

		return "<link rel='stylesheet' href='{$path}'>";
	}
}

if ( ! function_exists('script'))
{
	/**
	 * Generates the necessary HTML for a
	 * script link. Path should be relative
	 * to the js_path config option for Guard.
	 *
	 * @param  string $path
	 * @return string
	 */
	function script($path = 'scripts.min.js')
	{
		$publicDirName = basename(public_path());

		$path = \Config::get('guard-laravel::guard.js_path') . "/$path";
		$path = str_replace($publicDirName, '', $path);

		return "<script src='$path'></script>";
	}
}