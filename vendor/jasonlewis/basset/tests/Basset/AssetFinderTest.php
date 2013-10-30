<?php

use Mockery as m;
use Basset\AssetFinder;
use Illuminate\Config\Repository as Config;

class AssetFinderTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->config = m::mock('Illuminate\Config\Repository');

        $this->finder = new AssetFinder($this->files, $this->config, 'path/to/public');
    }


    public function testFindRemotelyHostedAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.http://foo.bar/baz.css', 'http://foo.bar/baz.css')->andReturn('http://foo.bar/baz.css');

        $this->assertEquals('http://foo.bar/baz.css', $this->finder->find('http://foo.bar/baz.css'));
    }


    public function testFindRelativeProtocolRemotelyHostedAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.//foo.bar/baz.css', '//foo.bar/baz.css')->andReturn('//foo.bar/baz.css');

        $this->assertEquals('//foo.bar/baz.css', $this->finder->find('//foo.bar/baz.css'));
    }


    public function testFindPackageAsset()
    {
        $this->finder->addNamespace('bar', 'foo/bar');

        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.bar::baz.css', 'bar::baz.css')->andReturn('bar::baz.css');
        $this->files->shouldReceive('exists')->once()->with('path/to/public/packages/foo/bar/baz.css')->andReturn(true);

        $this->assertEquals('path/to/public/packages/foo/bar/baz.css', $this->finder->find('bar::baz.css'));
    }


    /**
     * @expectedException Basset\Exceptions\AssetNotFoundException
     */
    public function testFindPackageAssetWithNoSetPackageThrowsNotFoundException()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.bar::baz.css', 'bar::baz.css')->andReturn('bar::baz.css');

        $this->files->shouldReceive('exists')->once()->with('path/to/public/bar::baz.css')->andReturn(false);
        $this->files->shouldReceive('exists')->once()->with('bar::baz.css')->andReturn(false);

        $this->assertNull($this->finder->find('bar::baz.css'));
    }


    public function testFindWorkingDirectoryAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.foo.css', 'foo.css')->andReturn('foo.css');

        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory')->andReturn(true);
        $this->finder->setWorkingDirectory('working/directory');
        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory/foo.css')->andReturn(true);

        $this->assertEquals('path/to/public/working/directory/foo.css', $this->finder->find('foo.css'));
    }


    public function testFindPublicPathAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.foo.css', 'foo.css')->andReturn('foo.css');

        $this->files->shouldReceive('exists')->once()->with('path/to/public/foo.css')->andReturn(true);

        $this->assertEquals('path/to/public/foo.css', $this->finder->find('foo.css'));
    }


    public function testFindAbsolutePathAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets./absolute/path/to/foo.css', '/absolute/path/to/foo.css')->andReturn('/absolute/path/to/foo.css');

        $this->files->shouldReceive('exists')->once()->with('path/to/public/absolute/path/to/foo.css')->andReturn(false);
        $this->files->shouldReceive('exists')->once()->with('/absolute/path/to/foo.css')->andReturn(true);

        $this->assertEquals('/absolute/path/to/foo.css', $this->finder->find('/absolute/path/to/foo.css'));
    }


    public function testFindAliasedAsset()
    {
        $this->config->shouldReceive('get')->once()->with('basset::aliases.assets.foo', 'foo')->andReturn('foo.css');

        $this->files->shouldReceive('exists')->once()->with('path/to/public/foo.css')->andReturn(true);

        $this->assertEquals('path/to/public/foo.css', $this->finder->find('foo'));
    }


    /**
     * @expectedException Basset\Exceptions\DirectoryNotFoundException
     */
    public function testSettingInvalidWorkingDirectoryThrowsException()
    {
        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory')->andReturn(false);
        $this->finder->setWorkingDirectory('working/directory');
    }


    public function testResettingWorkingDirectory()
    {
        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory')->andReturn(true);
        $this->finder->setWorkingDirectory('working/directory');
        $this->assertEquals('path/to/public/working/directory', $this->finder->getWorkingDirectory());

        $this->finder->resetWorkingDirectory();
        $this->assertFalse($this->finder->getWorkingDirectory());
    }


    public function testWorkingDirectoryStackIsPrefixed()
    {
        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory')->andReturn(true);
        $this->files->shouldReceive('exists')->once()->with('path/to/public/working/directory/foo/bar/baz')->andReturn(true);

        $this->finder->setWorkingDirectory('working/directory');
        $this->assertEquals('path/to/public/working/directory', $this->finder->getWorkingDirectory());

        $this->finder->setWorkingDirectory('foo/bar/baz');
        $this->assertEquals('path/to/public/working/directory/foo/bar/baz', $this->finder->getWorkingDirectory());

        $this->finder->resetWorkingDirectory();
        $this->assertEquals('path/to/public/working/directory', $this->finder->getWorkingDirectory());

        $this->finder->resetWorkingDirectory();
        $this->assertFalse($this->finder->getWorkingDirectory());
    }


}