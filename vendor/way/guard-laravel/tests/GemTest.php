<?php

use Mockery as m;

class GemTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		Mockery::close();
	}

	public function testCanInstallGemIfNotExists()
	{
		$gem = m::mock('Way\Console\Gem[exists,install]');

		// Let's assume that the gem is not installed on user's system
		$gem->shouldReceive('exists')->once()->andReturn(false);

		// Then the install method should be called
		$gem->shouldReceive('install')->once();

		$gem->mustBeAvailable('foo');
	}

	public function testDoesNothingIfGemExists()
	{
		$gem = m::mock('Way\Console\Gem[exists,install]');

		$gem->shouldReceive('exists')->once()->andReturn(true);
		$gem->shouldReceive('install')->never();

		$gem->mustBeAvailable('foo');
	}

}