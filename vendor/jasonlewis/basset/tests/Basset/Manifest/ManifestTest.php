<?php

use Mockery as m;

class RepositoryTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->files = new Illuminate\Filesystem\Filesystem;
        $this->manifest = new Basset\Manifest\Manifest($this->files, __DIR__.'/fixtures');
    }


    public function testManifestIsLoadedCorrectlyFromFilesystem()
    {
        $this->manifest->load();

        $this->assertEquals(array(
            'fingerprints' => array('stylesheets' => 'bar'),
            'development' => array('stylesheets' => array('baz/qux.scss' => 'baz/qux.css'))
        ), $this->manifest->get('foo')->toArray());
    }


    public function testGetInvalidManifestEntryReturnsNull()
    {
        $this->assertNull($this->manifest->get('foo'));
    }


    public function testMakeManifestEntryReturnsNewEntry()
    {
        $this->assertInstanceOf('Basset\Manifest\Entry', $this->manifest->make('foo'));
    }


    public function testMakeReturnsExistingManifestEntryIfEntryAlreadyExists()
    {
        $foo = $this->manifest->make('foo');
        $this->assertEquals($foo, $this->manifest->make('foo'));
    }


    public function testManifestChecksForExistingEntry()
    {
        $this->assertFalse($this->manifest->has('foo'));
        $this->manifest->make('foo');
        $this->assertTrue($this->manifest->has('foo'));
    }


    public function testManifestUsesCollectionInstanceToGetEntryName()
    {
        $collection = m::mock('Basset\Collection');
        $collection->shouldReceive('getIdentifier')->once()->andReturn('foo');
        $this->assertInstanceOf('Basset\Manifest\Entry', $this->manifest->make($collection));
    }


    public function testWritesChangedEntriesToManifest()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->manifest = new Basset\Manifest\Manifest($this->files, __DIR__.'/fixtures');

        $entry = $this->manifest->make('foo');
        $entry->setProductionFingerprint('stylesheets', 'foo-123.css');

        $this->files->shouldReceive('put')->once()->with(__DIR__.'/fixtures/collections.json', json_encode(array('foo' => $entry->toArray())))->andReturn(true);

        $this->assertTrue($this->manifest->save());
    }


    public function testNonDirtyManifestDoesNotSave()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->manifest = new Basset\Manifest\Manifest($this->files, __DIR__.'/fixtures');

        $this->assertFalse($this->manifest->save());
    }


}