<?php

use Mockery as m;
use Basset\Server;
use Illuminate\Http\Request;
use Basset\Manifest\Manifest;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Routing\RouteCollection;

class ServerTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->app = array(
            'env' => 'testing',
            'url' => new UrlGenerator(new RouteCollection, Request::create('http://localhost', 'GET')),
            'config' => m::mock('Illuminate\Config\Repository'),
            'basset' => m::mock('Basset\Environment'),
            'basset.manifest' => new Manifest(new Filesystem, 'meta'),
            'basset.builder' => m::mock('Basset\Builder\Builder'),
            'basset.builder.cleaner' => m::mock('Basset\Builder\FilesystemCleaner')
        );

        $this->server = new Server($this->app);
    }


    public function testServingInvalidCollectionReturnsHtmlComment()
    {
        $this->app['basset']->shouldReceive('offsetExists')->once()->with('foo')->andReturn(false);
        $this->assertEquals('<!-- Basset could not find collection: foo -->', $this->server->serve('foo', 'stylesheets'));
    }


    /**
     * @dataProvider providerServingProductionCollectionReturnsExpectedHtml
     */
    public function testServingProductionCollectionReturnsExpectedHtml($name, $group, $fingerprint, $expected)
    {
        $this->app['basset']->shouldReceive(array('offsetExists' => true, 'offsetGet' => $collection = m::mock('Basset\Collection')))->with($name);

        $this->app['config']->shouldReceive('get')->once()->with('basset::production')->andReturn('testing');

        $collection->shouldReceive('getAssetsOnlyRaw')->with($group)->andReturn(array());
        $collection->shouldReceive('getIdentifier')->andReturn($name);

        $entry = $this->app['basset.manifest']->make($collection);
        $entry->setProductionFingerprint($group, $fingerprint);

        $this->app['config']->shouldReceive('get')->with('basset::build_path')->andReturn('assets');

        $this->assertEquals($expected, $this->server->{$group}($name));
    }


    public function providerServingProductionCollectionReturnsExpectedHtml()
    {
        return array(
            array('foo', 'stylesheets', 'bar-123.css', '<link rel="stylesheet" type="text/css" href="http://localhost/assets/bar-123.css" />'),
            array('bar', 'javascripts', 'baz-321.js', '<script src="http://localhost/assets/baz-321.js"></script>'),
        );
    }


    public function testServingDevelopmentCollectionReturnsExpectedHtml()
    {
        $this->app['basset']->shouldReceive(array('offsetExists' => true, 'offsetGet' => $collection = m::mock('Basset\Collection')))->with('foo');
        
        $this->app['config']->shouldReceive('get')->once()->with('basset::production')->andReturn('prod');

        $this->app['basset.builder']->shouldReceive('buildAsDevelopment')->once()->with($collection, 'stylesheets');
        $this->app['basset.builder.cleaner']->shouldReceive('clean')->once()->with('foo');

        $collection->shouldReceive('getIdentifier')->andReturn('foo');
        $collection->shouldReceive('getAssetsWithRaw')->once()->with('stylesheets')->andReturn($assets = array(
            m::mock('Basset\Asset'),
            m::mock('Basset\Asset'),
            m::mock('Basset\Asset')
        ));

        $assets[0]->shouldReceive('isRaw')->once()->andReturn(false);
        $assets[0]->shouldReceive('getGroup')->once()->andReturn('stylesheets');
        $assets[0]->shouldReceive('getRelativePath')->once()->andReturn('bar.less');
        $assets[1]->shouldReceive('isRaw')->once()->andReturn(true);
        $assets[1]->shouldReceive('getRelativePath')->once()->andReturn('qux.css');
        $assets[2]->shouldReceive('isRaw')->once()->andReturn(false);
        $assets[2]->shouldReceive('getGroup')->once()->andReturn('stylesheets');
        $assets[2]->shouldReceive('getRelativePath')->once()->andReturn('baz.sass');

        $entry = $this->app['basset.manifest']->make($collection);
        $entry->addDevelopmentAsset('bar.less', 'bar.css', 'stylesheets');
        $entry->addDevelopmentAsset('baz.sass', 'baz.css', 'stylesheets');

        $this->app['config']->shouldReceive('get')->with('basset::build_path')->andReturn('assets');

        $expected = '<link rel="stylesheet" type="text/css" href="http://localhost/assets/foo/bar.css" />'.PHP_EOL.
                    '<link rel="stylesheet" type="text/css" href="http://localhost/qux.css" />'.PHP_EOL.
                    '<link rel="stylesheet" type="text/css" href="http://localhost/assets/foo/baz.css" />';
        $this->assertEquals($expected, $this->server->serve('foo', 'stylesheets'));
    }


    public function testRawAssetsAreServedBeforeBuiltCollectionHtml()
    {
        $this->app['basset']->shouldReceive(array('offsetExists' => true, 'offsetGet' => $collection = m::mock('Basset\Collection')))->with('foo');
        
        $this->app['config']->shouldReceive('get')->once()->with('basset::production')->andReturn('testing');

        $collection->shouldReceive('getAssetsOnlyRaw')->with('stylesheets')->andReturn(array($asset = m::mock('Basset\Asset')));
        $collection->shouldReceive('getIdentifier')->andReturn('foo');

        $asset->shouldReceive('getRelativePath')->andReturn('css/baz.css');

        $entry = $this->app['basset.manifest']->make($collection);
        $entry->setProductionFingerprint('stylesheets', 'bar-123.css');

        $this->app['config']->shouldReceive('get')->with('basset::build_path')->andReturn('assets');

        $expected = '<link rel="stylesheet" type="text/css" href="http://localhost/css/baz.css" />'.PHP_EOL.
                    '<link rel="stylesheet" type="text/css" href="http://localhost/assets/bar-123.css" />';
        $this->assertEquals($expected, $this->server->collection('foo.css'));
    }


    public function testServingCollectionsWithCustomFormat()
    {
        $this->app['basset']->shouldReceive(array('offsetExists' => true, 'offsetGet' => $collection = m::mock('Basset\Collection')))->with('foo');
        
        $this->app['config']->shouldReceive('get')->once()->with('basset::production')->andReturn('testing');

        $collection->shouldReceive('getAssetsOnlyRaw')->with('stylesheets')->andReturn(array());
        $collection->shouldReceive('getIdentifier')->andReturn('foo');

        $entry = $this->app['basset.manifest']->make($collection);
        $entry->setProductionFingerprint('stylesheets', 'foo-123.css');

        $this->app['config']->shouldReceive('get')->with('basset::build_path')->andReturn('assets');

        $expected = '<link rel="stylesheet" type="text/css" href="http://localhost/assets/foo-123.css" media="print" />';
        $this->assertEquals($expected, $this->server->stylesheets('foo', '<link rel="stylesheet" type="text/css" href="%s" media="print" />'));
    }


    public function testServingRawAssetsOnGivenEnvironment()
    {
        $this->app['basset']->shouldReceive(array('offsetExists' => true, 'offsetGet' => $collection = m::mock('Basset\Collection')))->with('foo');
        $this->app['config']->shouldReceive('get')->once()->with('basset::production')->andReturn('production');

        $this->app['basset.builder']->shouldReceive('buildAsDevelopment')->once()->with($collection, 'stylesheets');
        $this->app['basset.builder.cleaner']->shouldReceive('clean')->once()->with('foo');

        $collection->shouldReceive('getIdentifier')->andReturn('foo');
        $collection->shouldReceive('getAssetsWithRaw')->once()->with('stylesheets')->andReturn($assets = array(
            m::mock('Basset\Asset', array(new Filesystem, m::mock('Basset\Factory\FactoryManager'), 'testing', null, null))->shouldDeferMissing(),
            m::mock('Basset\Asset')->shouldDeferMissing()
        ));

        $assets[0]->rawOnEnvironment('testing');
        $assets[0]->shouldReceive('getRelativePath')->once()->andReturn('bar.css');
        $assets[1]->shouldReceive('isRaw')->once()->andReturn(false);
        $assets[1]->shouldReceive('getGroup')->once()->andReturn('stylesheets');
        $assets[1]->shouldReceive('getRelativePath')->once()->andReturn('baz.sass');

        $entry = $this->app['basset.manifest']->make($collection);
        $entry->addDevelopmentAsset('baz.sass', 'baz.css', 'stylesheets');

        $this->app['config']->shouldReceive('get')->with('basset::build_path')->andReturn('assets');

        $expected = '<link rel="stylesheet" type="text/css" href="http://localhost/bar.css" />'.PHP_EOL.
                    '<link rel="stylesheet" type="text/css" href="http://localhost/assets/foo/baz.css" />';
        $this->assertEquals($expected, $this->server->serve('foo', 'stylesheets'));
    }


}