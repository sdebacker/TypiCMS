<?php

use Mockery as m;

class FilesystemCleanerTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->environment = m::mock('Basset\Environment');
        $this->manifest = m::mock('Basset\Manifest\Manifest');
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');

        $this->cleaner = new Basset\Builder\FilesystemCleaner($this->environment, $this->manifest, $this->files, 'path/to/builds');

        $this->manifest->shouldReceive('save')->atLeast()->once();
    }


    public function testForgettingCollectionFromManifestThatNoLongerExistsOnEnvironment()
    {
        $this->environment->shouldReceive('offsetExists')->once()->with('foo')->andReturn(false);
        $this->manifest->shouldReceive('get')->once()->with('foo')->andReturn($entry = m::mock('Basset\Manifest\Entry'));
        $this->manifest->shouldReceive('forget')->once()->with('foo');

        $entry->shouldReceive('hasProductionFingerprints')->once()->andReturn(false);
        $this->files->shouldReceive('glob')->with('path/to/builds/foo-*.*')->andReturn(array('path/to/builds/foo-123.css'));
        $this->files->shouldReceive('delete')->with('path/to/builds/foo-123.css');
        $entry->shouldReceive('resetProductionFingerprints')->once();

        $entry->shouldReceive('hasDevelopmentAssets')->once()->andReturn(false);
        $this->files->shouldReceive('deleteDirectory')->once()->with('path/to/builds/foo');
        $entry->shouldReceive('resetDevelopmentAssets')->once();

        $this->cleaner->clean('foo');
    }


    public function testCleaningOfManifestFilesOnFilesystem()
    {
        $this->manifest->shouldReceive('get')->once()->with('foo')->andReturn($entry = m::mock('Basset\Manifest\Entry'));
        $this->environment->shouldReceive('offsetExists')->times(3)->with('foo')->andReturn(true);
        $this->environment->shouldReceive('offsetGet')->once()->with('foo')->andReturn($collection = m::mock('Basset\Collection'));

        $collection->shouldReceive('getIdentifier')->twice()->andReturn('foo');

        $entry->shouldReceive('getProductionFingerprints')->once()->andReturn(array(
            'foo-37b51d194a7513e45b56f6524f2d51f2.css',
            'bar-acbd18db4cc2f85cedef654fccc4a4d8.js'
        ));

        $this->files->shouldReceive('glob')->once()->with('path/to/builds/foo-*.css')->andReturn(array(
            'path/to/builds/foo-37b51d194a7513e45b56f6524f2d51f2.css',
            'path/to/builds/foo-asfjkb8912h498hacn8casc8h8942102.css'
        ));
        $this->files->shouldReceive('delete')->once()->with('path/to/builds/foo-asfjkb8912h498hacn8casc8h8942102.css')->andReturn(true);
        $this->files->shouldReceive('glob')->once()->with('path/to/builds/bar-*.js')->andReturn(array());

        $entry->shouldReceive('getDevelopmentAssets')->once()->andReturn(array(
            'stylesheets' => array('bar/baz-37b51d194a7513e45b56f6524f2d51f2.css', 'bar/qux-acbd18db4cc2f85cedef654fccc4a4d8.css'),
            'javascripts' => array()
        ));

        $this->files->shouldReceive('glob')->once()->with('path/to/builds/foo/bar/baz-*.css')->andReturn(array('path/to/builds/foo/bar/baz-37b51d194a7513e45b56f6524f2d51f2.css'));
        $this->files->shouldReceive('glob')->once()->with('path/to/builds/foo/bar/qux-*.css')->andReturn(array());

        $entry->shouldReceive('hasProductionFingerprints')->once()->andReturn(true);
        $entry->shouldReceive('hasDevelopmentAssets')->once()->andReturn(true);

        $this->cleaner->clean('foo');
    }


}