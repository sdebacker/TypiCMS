<?php

use Mockery as m;

class AssetFactoryTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->asset = new Basset\Factory\AssetFactory($this->files, 'testing', __DIR__);

        $this->asset->setLogger($this->log = m::mock('Illuminate\Log\Writer'));
        $this->asset->setFactoryManager(m::mock('Basset\Factory\FactoryManager'));
    }


    public function testMakeAsset()
    {
        $asset = $this->asset->make(__FILE__);

        $this->assertEquals(basename(__FILE__), $asset->getRelativePath());
        $this->assertEquals(__FILE__, $asset->getAbsolutePath());
    }


    public function testBuildingOfAbsolutePath()
    {
        $this->assertEquals(__FILE__, $this->asset->buildAbsolutePath(__FILE__));
        $this->assertEquals('http://foo.com', $this->asset->buildAbsolutePath('http://foo.com'));
        $this->assertEquals('//foo.com', $this->asset->buildAbsolutePath('//foo.com'));
    }

    public function testBuildingOfRelativePath()
    {
        $this->assertEquals('foo.css', $this->asset->buildRelativePath(__DIR__.'/foo.css'));
        $this->assertEquals('bar/foo.css', $this->asset->buildRelativePath(__DIR__.'/bar/foo.css'));
        $this->assertEquals('http://foo.com', $this->asset->buildRelativePath('http://foo.com'));
    }


    public function testBuildingOfRelativePathFromOutsidePublicDirectory()
    {
        $this->assertEquals(md5('path/to/outside').'/foo.css', $this->asset->buildRelativePath('path/to/outside/foo.css'));
        $this->assertEquals(md5('path/to').'/bar.css', $this->asset->buildRelativePath('path/to/bar.css'));
    }


}