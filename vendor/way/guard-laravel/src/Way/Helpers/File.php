<?php namespace Way\Helpers;

use Symfony\Component\Finder\Finder;

class File {

	/**
	 * Get an array of all files in a directory, recursively.
	 *
	 * @param  string $dir
	 * @return array
	 */
	public static function filesRecursive($dir)
	{
		$finder = new Finder;

		 return iterator_to_array($finder->files()->in($dir), false);
	}

	/**
	 * Removes extensions from array of files
	 *
	 * @param  array $fileList
	 * @return string
	 */
	public static function removeExtensions(array $fileList)
	{
		return array_map(function($file)
		{
			// If no extension is present, then it's set in the
			// config file, like vendor/jquery. In those cases,
			// just return the $file as it is.
			if (! pathinfo($file, PATHINFO_EXTENSION)) return $file;

			// If Symfony's Finder component was used...
			if (method_exists($file, 'getRelativePathName'))
			{
				$file = $file->getRelativePathName();
			}

			return preg_replace('/\.(css|js)$/', '', $file);
		}, $fileList);
	}

	/**
	 * We don't want merged file to ever be included.
	 *
	 * @param  array  $fileList
	 * @return array
	 */
	public static function deleteMinified(array $fileList)
	{
		return array_filter($fileList, function($file)
		{
			return ! preg_match('/\.min\.(js|css)$/i', $file);
		});
	}

	/**
	 * Get a recursive list of all files in a directory
	 * while removing their extensions, which is
	 * helpful for the guard-concat plugin
	 *
	 * @param  string $dir
	 * @return array
	 */
	public static function withoutExtensionsFrom($dir)
	{
		$dir = base_path().'/'.$dir;

		if (! file_exists($dir)) return array();

		$fileList = static::filesRecursive($dir);

		return static::removeExtensions(static::deleteMinified($fileList));
	}

}