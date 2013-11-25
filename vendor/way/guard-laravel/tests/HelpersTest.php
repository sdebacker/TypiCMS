<?php

use Way\Helpers\Helpers;

class HelpersTest extends PHPUnit_Framework_TestCase {
	public function testArrayToRuby()
	{
		$options = [
			'style' => ':compressed',
			'line_numbers' => true
 		];

		$result = Helpers::arrayToRuby($options);

		$this->assertEquals(':style => :compressed', $result[0]);
		$this->assertEquals(':line_numbers => true', $result[1]);
	}
}