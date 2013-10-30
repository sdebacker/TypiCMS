<?php

use Mockery as m;
use Basset\Asset;
use Basset\Manifest\Entry;

class EntryTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->data = array(
            'fingerprints' => array(
                'stylesheets' => 'foo-123.css'
            ),
            'development' => array(
                'stylesheets' => array(
                    'bar/baz.sass' => 'bar/baz.css'
                ),
                'javascripts' => array(
                    'baz/qux.coffee' => 'baz/qux.js'
                )
            )
        );

        $this->entry = new Entry($this->data['fingerprints'], $this->data['development']);
    }


    public function testDefaultArrayIsParsedCorrectly()
    {
        $this->assertEquals($this->data, $this->entry->toArray());
    }


    public function testAddingDevelopmentAssetToEntry()
    {
        $this->entry->addDevelopmentAsset('foo/bar.sass', 'foo/bar.css', 'stylesheets');
        $this->data['development']['stylesheets']['foo/bar.sass'] = 'foo/bar.css';
        $this->assertEquals($this->data, $this->entry->toArray());
    }


    public function testAddingDevelopmentAssetToEntryFromAssetInstance()
    {
        $asset = new Asset($files = m::mock('Illuminate\Filesystem\Filesystem'), m::mock('Basset\Factory\FactoryManager'), 'testing', 'foo/bar.sass', 'foo/bar.sass');
        $files->shouldReceive('lastModified')->once()->with('foo/bar.sass')->andReturn(time());
        $this->entry->addDevelopmentAsset($asset);
        $this->data['development']['stylesheets']['foo/bar.sass'] = 'foo/bar-'.md5('[]'.time()).'.css';
        $this->assertEquals($this->data, $this->entry->toArray());
    }


    public function testGettingDevelopmentAsset()
    {
        $this->assertEquals('bar/baz.css', $this->entry->getDevelopmentAsset('bar/baz.sass', 'stylesheets'));
    }


    public function testGettingInvalidDevelopmentAssetReturnsNull()
    {
        $this->assertNull($this->entry->getDevelopmentAsset('foo/bar.sass', 'stylesheets'));
    }


    public function testGettingDevelopmentAssetFromAssetInstance()
    {
        $asset = m::mock('Basset\Asset');
        $asset->shouldReceive('getGroup')->once()->andReturn('stylesheets');
        $asset->shouldReceive('getRelativePath')->once()->andReturn('bar/baz.sass');
        $this->assertEquals('bar/baz.css', $this->entry->getDevelopmentAsset($asset));
    }


    public function testCheckingForDevelopmentAssetExistence()
    {
        $this->assertFalse($this->entry->hasDevelopmentAsset('foo/bar.css', 'stylesheets'));
        $this->assertTrue($this->entry->hasDevelopmentAsset('bar/baz.sass', 'stylesheets'));
    }


    public function testGetAllDevelopmentAssets()
    {
        $this->assertEquals($this->data['development'], $this->entry->getDevelopmentAssets());
    }


    public function testGetAllDevelopmentAssetsForGivenGroup()
    {
        $this->assertEquals($this->data['development']['javascripts'], $this->entry->getDevelopmentAssets('javascripts'));
    }


    public function testCheckingForExistenceOfAnyDevelopmentAssets()
    {
        $this->assertTrue($this->entry->hasDevelopmentAssets());
    }


    public function testCheckingForExistenceOfSpecificDevelopmentAssetsGroup()
    {
        $this->entry->resetDevelopmentAssets('javascripts');
        $this->assertFalse($this->entry->hasDevelopmentAssets('javascripts'));
    }


    public function testResettingAllDevelopmentAssets()
    {
        $this->entry->resetDevelopmentAssets();
        $this->assertEmpty($this->entry->getDevelopmentAssets());
    }


    public function testResettingSpecificDevelopmentAssetsGroup()
    {
        $this->entry->resetDevelopmentAssets('javascripts');
        $this->assertEmpty($this->entry->getDevelopmentAssets('javascripts'));
    }


    public function testSettingProductionFingerprintOnGroup()
    {
        $this->entry->setProductionFingerprint('javascripts', 'foo-321.js');
        $this->assertEquals('foo-321.js', $this->entry->getProductionFingerprint('javascripts'));
    }


    public function testCheckingForExistenceOfFingerprint()
    {
        $this->assertTrue($this->entry->hasProductionFingerprint('stylesheets'));
        $this->assertFalse($this->entry->hasProductionFingerprint('javascripts'));
    }


    public function testGettingAllProductionFingerprints()
    {
        $this->assertEquals($this->data['fingerprints'], $this->entry->getProductionFingerprints());
    }


    public function testGettingEntryAsJson()
    {
        $this->assertEquals(json_encode($this->data), $this->entry->toJson());
    }


    public function testGettingEntryAsArray()
    {
        $this->assertEquals($this->data, $this->entry->toArray());
    }


}