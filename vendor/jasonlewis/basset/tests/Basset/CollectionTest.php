<?php

use Mockery as m;
use Basset\Asset;
use Basset\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

class CollectionTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->collection = new Collection($this->directory = m::mock('Basset\Directory'), 'foo');
    }


    public function testGetIdentifierOfCollection()
    {
        $this->assertEquals('foo', $this->collection->getIdentifier());
    }


    public function testGetDefaultDirectory()
    {
        $this->assertEquals($this->directory, $this->collection->getDefaultDirectory());
    }


    public function testGetExtensionFromGroup()
    {
        $this->assertEquals('css', $this->collection->getExtension('stylesheets'));
        $this->assertEquals('js', $this->collection->getExtension('javascripts'));
    }


    public function testGettingCollectionAssetsWithDefaultOrdering()
    {
        $this->directory->shouldReceive('getAssets')->andReturn($expected = new IlluminateCollection(array(
            $this->getAssetInstance('bar.css', 'path/to/bar.css', 'stylesheets', 1),
            $this->getAssetInstance('baz.css', 'path/to/baz.css', 'stylesheets', 2)
        )));

        $this->assertEquals($expected->all(), $this->collection->getAssets('stylesheets')->all());
    }


    public function testGettingCollectionWithMultipleAssetGroupsReturnsOnlyRequestedGroup()
    {
        $this->directory->shouldReceive('getAssets')->andReturn(new IlluminateCollection(array(
            $assets[] = $this->getAssetInstance('foo.css', 'path/to/foo.css', 'stylesheets', 1),
            $assets[] = $this->getAssetInstance('bar.js', 'path/to/bar.js', 'javascripts', 2),
            $assets[] = $this->getAssetInstance('baz.js', 'path/to/baz.js', 'javascripts', 3),
            $assets[] = $this->getAssetInstance('qux.css', 'path/to/qux.css', 'stylesheets', 4)
        )));

        $expected = array(0 => $assets[0], 3 => $assets[3]);
        $this->assertEquals($expected, $this->collection->getAssets('stylesheets')->all());
    }


    public function testGettingCollectionAssetsWithCustomOrdering()
    {
        $this->directory->shouldReceive('getAssets')->andReturn(new IlluminateCollection(array(
            $assets[] = $this->getAssetInstance('foo.css', 'path/to/foo.css', 'stylesheets', 1), // Becomes 2nd
            $assets[] = $this->getAssetInstance('bar.css', 'path/to/bar.css', 'stylesheets', 2), // Becomes 4th
            $assets[] = $this->getAssetInstance('baz.css', 'path/to/baz.css', 'stylesheets', 1), // Becomes 1st
            $assets[] = $this->getAssetInstance('qux.css', 'path/to/qux.css', 'stylesheets', 4), // Becomes 5th
            $assets[] = $this->getAssetInstance('zin.css', 'path/to/zin.css', 'stylesheets', 3)  // Becomes 3rd
        )));

        $expected = array($assets[2], $assets[0], $assets[4], $assets[1], $assets[3]);
        $this->assertEquals($expected, $this->collection->getAssets('stylesheets')->all());
    }


    public function testGettingCollectionRawAssets()
    {
        $this->directory->shouldReceive('getAssets')->andReturn(new IlluminateCollection(array(
            $assets[] = $this->getAssetInstance('foo.css', 'path/to/foo.css', 'stylesheets', 1),
            $assets[] = $this->getAssetInstance('bar.css', 'path/to/bar.css', 'stylesheets', 2)
        )));

        $assets[1]->raw();

        $this->assertEquals(array(1 => $assets[1]), $this->collection->getAssetsOnlyRaw('stylesheets')->all());
    }


    public function getAssetInstance($relative, $absolute, $group, $order)
    {
        $asset = new Asset(m::mock('Illuminate\Filesystem\Filesystem'), m::mock('Basset\Factory\FactoryManager'), 'testing', $absolute, $relative);

        return $asset->setOrder($order)->setGroup($group);
    }


}