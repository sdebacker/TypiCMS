<?php

use Mockery as m;
use Basset\Asset;
use Basset\Factory\FilterFactory;

class AssetTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->files = m::mock('Illuminate\Filesystem\Filesystem');
        $this->factory = m::mock('Basset\Factory\FactoryManager');
        $this->log = m::mock('Illuminate\Log\Writer');
        $this->filter = m::mock('Basset\Factory\FilterFactory', array(array(), array(), 'testing'))->shouldDeferMissing();

        $this->factory->shouldReceive('get')->with('filter')->andReturn($this->filter);

        $this->files->shouldReceive('lastModified')->with('path/to/public/foo/bar.sass')->andReturn('1368422603');

        $this->asset = new Asset($this->files, $this->factory, 'testing', 'path/to/public/foo/bar.sass', 'foo/bar.sass');
        $this->asset->setOrder(1);
        $this->asset->setGroup('stylesheets');
    }


    public function testGetAssetProperties()
    {
        $this->assertEquals('foo/bar.sass', $this->asset->getRelativePath());
        $this->assertEquals('path/to/public/foo/bar.sass', $this->asset->getAbsolutePath());
        $this->assertEquals('foo/bar-2a4bdbebcbf798cb0b59078d98136e3d.css', $this->asset->getBuildPath());
        $this->assertEquals('css', $this->asset->getBuildExtension());
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->asset->getFilters());
        $this->assertEquals('stylesheets', $this->asset->getGroup());
        $this->assertEquals('1368422603', $this->asset->getLastModified());
    }


    public function testAssetsCanBeServedRaw()
    {
        $this->asset->raw();
        $this->assertTrue($this->asset->isRaw());
    }


    public function testCheckingOfAssetGroup()
    {
        $this->assertTrue($this->asset->isStylesheet());
        $this->assertFalse($this->asset->isJavascript());
    }


    public function testCheckingOfAssetGroupWhenNoGroupSupplied()
    {
        $this->asset->setGroup(null);
        $this->assertTrue($this->asset->isStylesheet());
    }


    public function testAssetCanBeRemotelyHosted()
    {
        $asset = new Asset($this->files, $this->factory, 'testing', 'http://foo.com/bar.css', 'http://foo.com/bar.css');

        $this->assertTrue($asset->isRemote());
    }


    public function testAssetCanBeRemotelyHostedWithRelativeProtocol()
    {
        $asset = new Asset($this->files, $this->factory, 'testing', '//foo.com/bar.css', '//foo.com/bar.css');

        $this->assertTrue($asset->isRemote());
    }


    public function testSettingCustomOrderOfAsset()
    {
        $this->asset->first();
        $this->assertEquals(1, $this->asset->getOrder());

        $this->asset->second();
        $this->assertEquals(2, $this->asset->getOrder());

        $this->asset->third();
        $this->assertEquals(3, $this->asset->getOrder());

        $this->asset->order(10);
        $this->assertEquals(10, $this->asset->getOrder());
    }


    public function testFiltersAreAppliedToAssets()
    {
        $this->filter->shouldReceive('make')->once()->with('FooFilter')->andReturn($filter = m::mock('Basset\Filter\Filter'));
        
        $filter->shouldReceive('setResource')->once()->with($this->asset)->andReturn(m::self());
        $filter->shouldReceive('getFilter')->once()->andReturn('FooFilter');

        $this->asset->apply('FooFilter');

        $filters = $this->asset->getFilters();
        
        $this->assertArrayHasKey('FooFilter', $filters->all());
        $this->assertInstanceOf('Basset\Filter\Filter', $filters['FooFilter']);
    }


    public function testArrayOfFiltersAreAppliedToAssets()
    {
        $this->filter->shouldReceive('make')->once()->with('FooFilter')->andReturn($filter = m::mock('Basset\Filter\Filter'));
        $filter->shouldReceive('setResource')->once()->with($this->asset)->andReturn(m::self());
        $filter->shouldReceive('getFilter')->once()->andReturn('FooFilter');

        $this->filter->shouldReceive('make')->once()->with('BarFilter')->andReturn($filter = m::mock('Basset\Filter\Filter'));
        $filter->shouldReceive('setResource')->once()->with($this->asset)->andReturn(m::self());
        $filter->shouldReceive('getFilter')->once()->andReturn('BarFilter');

        $this->asset->apply(array('FooFilter', 'BarFilter'));

        $filters = $this->asset->getFilters();
        
        $this->assertArrayHasKey('FooFilter', $filters->all());
        $this->assertArrayHasKey('BarFilter', $filters->all());
    }


    public function testArrayOfFiltersWithCallbacksAreAppliedToAssets()
    {
        $this->filter->shouldReceive('make')->once()->with('FooFilter')->andReturn($filter = m::mock('Basset\Filter\Filter'));
        $filter->shouldReceive('setResource')->once()->with($this->asset)->andReturn(m::self());
        $filter->shouldReceive('getFilter')->once()->andReturn('FooFilter');

        $this->asset->apply(array('FooFilter' => function($filter)
        {
            $filter->applied = true;
        }));

        $this->assertTrue($filter->applied);
    }


    public function testFiltersArePreparedCorrectly()
    {
        $fooFilter = m::mock('Basset\Filter\Filter', array(m::mock('Illuminate\Log\Writer'), 'FooFilter', array(), 'testing'))->shouldDeferMissing();
        $fooFilterInstance = m::mock('stdClass, Assetic\Filter\FilterInterface');
        $fooFilter->shouldReceive('getClassName')->once()->andReturn($fooFilterInstance);

        $barFilter = m::mock('Basset\Filter\Filter', array($barLog = m::mock('Illuminate\Log\Writer'), 'BarFilter', array(), 'testing'))->shouldDeferMissing();
        $barFilter->shouldReceive('getClassName')->once()->andReturn(m::mock('stdClass, Assetic\Filter\FilterInterface'));

        $bazFilter = m::mock('Basset\Filter\Filter', array($bazLog = m::mock('Illuminate\Log\Writer'), 'BazFilter', array(), 'testing'))->shouldDeferMissing();
        $bazFilter->shouldReceive('getClassName')->once()->andReturn(m::mock('stdClass, Assetic\Filter\FilterInterface'));

        $quxFilter = m::mock('Basset\Filter\Filter', array($quxLog = m::mock('Illuminate\Log\Writer'), 'QuxFilter', array(), 'testing'))->shouldDeferMissing();
        $quxFilter->shouldReceive('getClassName')->once()->andReturn(m::mock('stdClass, Assetic\Filter\FilterInterface'));

        $vanFilter = m::mock('Basset\Filter\Filter', array(m::mock('Illuminate\Log\Writer'), 'VanFilter', array(), 'testing'))->shouldDeferMissing();
        $vanFilterInstance = m::mock('stdClass, Assetic\Filter\FilterInterface');
        $vanFilter->shouldReceive('getClassName')->once()->andReturn($vanFilterInstance);

        $this->asset->apply($fooFilter);
        $this->asset->apply($barFilter)->whenAssetIsJavascript();
        $this->asset->apply($bazFilter)->whenEnvironmentIs('production');
        $this->asset->apply($quxFilter)->whenAssetIs('.*\.js');
        $this->asset->apply($vanFilter)->whenAssetIs('.*\.sass');

        $filters = $this->asset->prepareFilters();

        $this->assertTrue($filters->has('FooFilter'));
        $this->assertTrue($filters->has('VanFilter'));
        $this->assertFalse($filters->has('BarFilter'));
        $this->assertFalse($filters->has('BazFilter'));
        $this->assertFalse($filters->has('QuxFilter'));
    }


    public function testAssetIsBuiltCorrectly()
    {
        $contents = 'html { background-color: #fff; }';

        $instantiatedFilter = m::mock('Assetic\Filter\FilterInterface');
        $instantiatedFilter->shouldReceive('filterLoad')->once()->andReturn(null);
        $instantiatedFilter->shouldReceive('filterDump')->once()->andReturnUsing(function($asset) use ($contents)
        {
            $asset->setContent(str_replace('html', 'body', $contents));
        });

        $filter = m::mock('Basset\Filter\Filter')->shouldDeferMissing();
        $filter->shouldReceive('setResource')->once()->with($this->asset)->andReturn(m::self());
        $filter->shouldReceive('getFilter')->once()->andReturn('BodyFilter');
        $filter->shouldReceive('getInstance')->once()->andReturn($instantiatedFilter);


        $config = m::mock('Illuminate\Config\Repository');

        $this->files->shouldReceive('getRemote')->once()->with('path/to/public/foo/bar.sass')->andReturn($contents);

        $this->asset->apply($filter);

        $this->assertEquals('body { background-color: #fff; }', $this->asset->build());
    }


}