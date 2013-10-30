<?php

use Mockery as m;
use Basset\Asset;
use Basset\Directory;
use Basset\AssetFinder;

class DirectoryTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->finder = m::mock('Basset\AssetFinder');
        $this->factory = m::mock('Basset\Factory\FactoryManager');
        $this->asset = m::mock('Basset\Factory\AssetFactory', array($this->files, $this->factory, 'testing', 'path/to/public'))->shouldDeferMissing();

        $this->factory->shouldReceive('get')->with('asset')->andReturn($this->asset);

        $this->directory = new Directory($this->factory, $this->finder, 'foo');
    }


    public function getAssetInstance($absolute = null, $relative = null)
    {
        return new Asset($this->files, $this->factory, 'testing', $absolute, $relative);
    }


    public function getLoggerMock()
    {
        return m::mock('Illuminate\Log\Writer');
    }


    public function testAddingBasicAssetFromPublicDirectory()
    {
        $asset = $this->getAssetInstance();

        $this->finder->shouldReceive('find')->once()->with('foo.css')->andReturn('path/to/foo.css');
        $this->asset->shouldReceive('make')->once()->with('path/to/foo.css')->andReturn($asset);

        $this->assertInstanceOf('Basset\Asset', $this->directory->stylesheet('foo.css'));
        $this->assertCount(1, $this->directory->getDirectoryAssets());
    }


    public function testAddingInvalidAssetReturnsBlankAssetInstance()
    {
        $asset = $this->getAssetInstance();

        $this->finder->shouldReceive('find')->once()->with('foo.css')->andThrow('Basset\Exceptions\AssetNotFoundException');
        $this->asset->shouldReceive('make')->once()->with(null)->andReturn($asset);

        $logger = $this->getLoggerMock()->shouldReceive('error')->once()->getMock();
        $this->factory->shouldReceive('getLogger')->once()->andReturn($logger);

        $this->assertInstanceOf('Basset\Asset', $this->directory->stylesheet('foo.css'));
        $this->assertCount(0, $this->directory->getDirectoryAssets());
    }


    public function testAddingAssetFiresCallback()
    {
        $asset = $this->getAssetInstance();

        $this->finder->shouldReceive('find')->once()->with('foo.js')->andReturn('path/to/foo.js');
        $this->asset->shouldReceive('make')->once()->with('path/to/foo.js')->andReturn($asset);

        $fired = false;

        $this->directory->javascript('foo.js', function() use (&$fired) { $fired = true; });
        $this->assertTrue($fired);
    }


    public function testChangingWorkingDirectory()
    {
        $this->finder->shouldReceive('setWorkingDirectory')->once()->with('css')->andReturn('path/to/public/css');
        $this->finder->shouldReceive('resetWorkingDirectory');

        $this->assertInstanceOf('Basset\Directory', $this->directory->directory('css'));
    }


    public function testChangingWorkingDirectoryToInvalidDirectoryReturnsBlankDirectoryInstance()
    {
        $this->finder->shouldReceive('setWorkingDirectory')->once()->with('css')->andThrow('Basset\Exceptions\DirectoryNotFoundException');
        $this->factory->shouldReceive('getLogger')->once()->andReturn(m::mock('Illuminate\Log\Writer')->shouldReceive('error')->once()->getMock());

        $this->assertInstanceOf('Basset\Directory', $this->directory->directory('css'));
    }


    public function testChangingWorkingDirectoryFiresCallback()
    {
        $this->finder->shouldReceive('setWorkingDirectory')->once()->with('css')->andReturn('path/to/public/css');
        $this->finder->shouldReceive('resetWorkingDirectory');

        $fired = false;
        $this->directory->directory('css', function() use (&$fired) { $fired = true; });
        $this->assertTrue($fired);
    }


    public function testRequireCurrentWorkingDirectory()
    {
        $directory = m::mock('Basset\Directory[iterateDirectory]', array($this->factory, $this->finder, 'foo'));
        $directory->shouldReceive('iterateDirectory')->once()->with('foo')->andReturn($iterator = m::mock('Iterator'));

        $iterator->shouldReceive('rewind')->once();
        $iterator->shouldReceive('valid')->times()->andReturn(true, true, false);
        $iterator->shouldReceive('current')->once()->andReturn($files[] = m::mock('SplFileInfo'));
        $iterator->shouldReceive('current')->once()->andReturn($files[] = m::mock('SplFileInfo'));
        $iterator->shouldReceive('next')->twice();

        $files[0]->shouldReceive('isFile')->andReturn(true);
        $files[0]->shouldReceive('getPathname')->andReturn('foo/bar.css');
        $files[1]->shouldReceive('isFile')->andReturn(false);

        $asset = $this->getAssetInstance();
        $this->finder->shouldReceive('find')->once()->with('foo/bar.css')->andReturn('foo/bar.css');
        $this->asset->shouldReceive('make')->once()->with('foo/bar.css')->andReturn($asset);

        $directory->requireDirectory();
        $this->assertCount(1, $directory->getDirectoryAssets());
    }


    public function testRequireDirectoryChangesDirectoryAndRequiresNewWorkingDirectory()
    {
        $directory = m::mock('Basset\Directory[directory]', array($this->factory, $this->finder, 'foo'));

        $requireDirectory = m::mock('Basset\Directory[iterateDirectory]', array($this->factory, $this->finder, 'foo/bar'));
        $directory->shouldReceive('directory')->with('bar')->andReturn($requireDirectory);

        $requireDirectory->shouldReceive('iterateDirectory')->once()->with('foo/bar')->andReturn($iterator = m::mock('Iterator'));

        $iterator->shouldReceive('rewind')->once();
        $iterator->shouldReceive('valid')->twice()->andReturn(true, false);
        $iterator->shouldReceive('current')->once()->andReturn($file = m::mock('SplFileInfo'));
        $iterator->shouldReceive('next')->once();

        $file->shouldReceive('isFile')->andReturn(true);
        $file->shouldReceive('getPathname')->andReturn('foo/bar/baz.css');

        $asset = $this->getAssetInstance();
        $this->finder->shouldReceive('find')->once()->with('foo/bar/baz.css')->andReturn('foo/bar/baz.css');
        $this->asset->shouldReceive('make')->once()->with('foo/bar/baz.css')->andReturn($asset);

        $directory->requireDirectory('bar');
        $this->assertCount(1, $requireDirectory->getDirectoryAssets());
    }


    public function testRequireCurrentWorkingDirectoryTree()
    {
        $directory = m::mock('Basset\Directory[recursivelyIterateDirectory]', array($this->factory, $this->finder, 'foo'));
        $directory->shouldReceive('recursivelyIterateDirectory')->once()->with('foo')->andReturn($iterator = m::mock('Iterator'));

        $iterator->shouldReceive('rewind')->once();
        $iterator->shouldReceive('valid')->once()->andReturn(false);

        $directory->requireTree();
        $this->assertCount(0, $directory->getDirectoryAssets());
    }


    public function testRequireTreeChangesWorkingDirectoryAndRequiresNewDirectoryTree()
    {
        $directory = m::mock('Basset\Directory[directory]', array($this->factory, $this->finder, 'foo'));

        $requireTree = m::mock('Basset\Directory[recursivelyIterateDirectory]', array($this->factory, $this->finder, 'foo/bar'));
        $directory->shouldReceive('directory')->once()->with('bar')->andReturn($requireTree);

        $requireTree->shouldReceive('recursivelyIterateDirectory')->once()->with('foo/bar')->andReturn($iterator = m::mock('Iterator'));

        $iterator->shouldReceive('rewind')->once();
        $iterator->shouldReceive('valid')->once()->andReturn(false);

        $directory->requireTree('bar');
        $this->assertCount(0, $directory->getDirectoryAssets());
    }


    public function testCanGetFilesystemIterator()
    {
        $this->assertInstanceOf('FilesystemIterator', $this->directory->iterateDirectory(__DIR__));
    }


    public function testCanGetRecursiveDirectoryIterator()
    {
        $this->assertInstanceOf('RecursiveIteratorIterator', $this->directory->recursivelyIterateDirectory(__DIR__));
    }


    public function testGettingIteratorsReturnsFalseForInvalidDirectories()
    {
        $this->assertFalse($this->directory->iterateDirectory('foo'));
        $this->assertFalse($this->directory->recursivelyIterateDirectory('foo'));
    }


    public function testGettingOfDirectoryPath()
    {
        $this->assertEquals('foo', $this->directory->getPath());
    }


    public function testExcludingOfAssetsFromDirectory()
    {
        $fooAsset = $this->getAssetInstance('path/to/foo.css', 'foo.css');
        $fooAsset->setOrder(1);
        $barAsset = $this->getAssetInstance('path/to/bar.css', 'bar.css');
        $barAsset->setOrder(1);

        $this->finder->shouldReceive('find')->once()->with('foo.css')->andReturn('path/to/foo.css');
        $this->asset->shouldReceive('make')->once()->with('path/to/foo.css')->andReturn($fooAsset);

        $this->finder->shouldReceive('find')->once()->with('bar.css')->andReturn('path/to/bar.css');
        $this->asset->shouldReceive('make')->once()->with('path/to/bar.css')->andReturn($barAsset);

        $this->directory->stylesheet('foo.css');
        $this->directory->stylesheet('bar.css');

        $this->directory->except('foo.css');

        $this->assertEquals($barAsset, $this->directory->getDirectoryAssets()->first());
    }


    public function testIncludingOfAssetsFromDirectory()
    {
        $fooAsset = $this->getAssetInstance('path/to/foo.css', 'foo.css');
        $fooAsset->setOrder(1);
        $barAsset = $this->getAssetInstance('path/to/bar.css', 'bar.css');
        $barAsset->setOrder(1);

        $this->finder->shouldReceive('find')->once()->with('foo.css')->andReturn('path/to/foo.css');
        $this->asset->shouldReceive('make')->once()->with('path/to/foo.css')->andReturn($fooAsset);

        $this->finder->shouldReceive('find')->once()->with('bar.css')->andReturn('path/to/bar.css');
        $this->asset->shouldReceive('make')->once()->with('path/to/bar.css')->andReturn($barAsset);

        $this->directory->stylesheet('foo.css');
        $this->directory->stylesheet('bar.css');

        $this->directory->only('foo.css');

        $this->assertEquals($fooAsset, $this->directory->getDirectoryAssets()->first());
    }


    public function testGetAssetsFromDirectory()
    {
        $this->assertCount(0, $this->directory->getAssets());
    }


    public function testGetAssetsFromDirectoryAndChildDirectories()
    {        
        $this->finder->shouldReceive('setWorkingDirectory')->once()->with('css')->andReturn('path/to/public/css');
        $this->finder->shouldReceive('resetWorkingDirectory');

        $this->directory->directory('css');

        $this->assertCount(0, $this->directory->getAssets());
    }


}