<?php namespace Way\Helpers;

class Helpers {
	/**
	 * Format PHP array to Ruby syntax
	 *
	 * @param  array $pluginOptions
	 * @return array
	 */
	public static function arrayToRuby(array $pluginOptions)
	{
		$rubyFormattedOptions = array();

		foreach($pluginOptions as $key => $val)
		{
			$val = var_export($val, true);

			// Some values can be set as symbols
			// If so, we need to convert them for Ruby
			if (starts_with($val, "':"))
			{
				// ':compressed' to :compressed
				$val = trim($val, "'");
			}

			$rubyFormattedOptions[] =  ":$key => $val";
		}

		return $rubyFormattedOptions;
	}
}