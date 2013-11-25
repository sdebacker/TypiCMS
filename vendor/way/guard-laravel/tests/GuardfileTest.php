<?php namespace Way\Console;

use \Way\Console\Guardfile;
use \Mockery as m;

// mock base_path
function base_path()
{
	return '';
}

class GuardfileTest extends \PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	public function testStoresFilesystemOnInstance()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$guardFile = new Guardfile($file, $config);

		$fileProperty = $this->makePublic($guardFile, 'file');
		$this->assertInstanceOf('Illuminate\Filesystem\Filesystem', $fileProperty->getValue($guardFile));
	}

	public function testDefaultPath()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$guardFile = new Guardfile($file, $config);

		$pathProperty = $this->makePublic($guardFile, 'path');

		$this->assertEquals('', $pathProperty->getValue($guardFile));
	}

	public function testCanSetPathUponInstantiation()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$guardFile = new Guardfile($file, $config, 'foo/bar');

		$pathProperty = $this->makePublic($guardFile, 'path');

		$this->assertEquals('foo/bar', $pathProperty->getValue($guardFile));
	}

	public function testGetPath()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');
		$guardFile = new Guardfile($file, $config);

		$this->assertEquals('/Guardfile', $guardFile->getPath());
	}

	public function testCanGetContentsOfGuardfile()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');
		$guardFile = new Guardfile($file, $config);

		$file->shouldReceive('get')->once()->with('/Guardfile');

		$guardFile->getContents();
	}

	public function testCanPutToGuardFile()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');
		$guardFile = new Guardfile($file, $config);

		$file->shouldReceive('put')->once()->with('/Guardfile', 'foo');

		$guardFile->put('foo');
	}

	public function testGetStubs()
	{
		$guardFile = m::mock('Way\Console\Guardfile')->makePartial();

		$guardFile->shouldReceive('getPluginStub')
				  ->times(2)
				  ->with(m::anyOf('sass', 'coffeescript'));

		$guardFile->shouldReceive('compile')
				   ->times(2)
				   ->with(m::any(), m::anyOf('sass', 'coffeescript'))
				   ->andReturn('foo');

		$content = $guardFile->getStubs(['sass', 'coffeescript']);

		$this->assertEquals("foo\n\nfoo", $content);
	}

	public function testGetPluginStub()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$file->shouldReceive('exists')
			 ->once()
			 ->andReturn(true);

		$file->shouldReceive('get')
			 ->once()
			 ->andReturn('foo');

		$guardFile = new Guardfile($file, $config);

		$stub = $guardFile->getPluginStub('sass');

		$this->assertEquals('foo', $stub);
	}

	/**
	 * @expectedException Way\Console\FileNotFoundException
	 */
	public function testGetPluginStubThrowsErrorIfFileDoesNotExist()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$file->shouldReceive('exists')
			 ->once()
			 ->andReturn(false); // simulate file doesn't exist

		(new Guardfile($file, $config))->getPluginStub('sass');
	}

	public function testGetFilesToConcat()
	{
		$cssConcat = ['main.css', 'buttons.css', 'vendor/normalize.css', 'vendor/libs/thing.css'];

		$guardFile = m::mock('Way\Console\Guardfile')->makePartial();

		$guardFile->shouldReceive('getConfigOption')
				  ->with('css_concat')
				  ->once()
				  ->andReturn($cssConcat);

		$result = $guardFile->getFilesToConcat('css');

		$this->assertEquals(['main', 'buttons', 'vendor/normalize', 'vendor/libs/thing'], $result);
	}

	public function testCompileStub()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem');
		$config = m::mock('Illuminate\Config\Repository');

		$guardFile = m::mock('Way\Console\Guardfile', [$file, $config])->makePartial();
		$guardFile->shouldReceive('getConfigOption')
				  ->with('/_path$/i')
				  ->times(2)
				  ->andReturn('assets', 'css');

		$guardFile->shouldReceive('getConfigOption')
				  ->with('guard_options.sass')
				  ->once()
				  ->andReturn(['style' => ':compressed']);

		// Let's make sure that the before stub, once compiled, looks like the after stub.
		$compiled = $guardFile->compile(file_get_contents(__DIR__.'/stubs/single-stub-before.txt'), 'sass');
		$this->assertEquals(file_get_contents(__DIR__.'/stubs/single-stub-after.txt'), $compiled);
	}

	protected function makePublic($obj, $property)
	{
		$reflect = new \ReflectionObject($obj);
		$property = $reflect->getProperty($property);
		$property->setAccessible(true);

		return $property;
	}

}