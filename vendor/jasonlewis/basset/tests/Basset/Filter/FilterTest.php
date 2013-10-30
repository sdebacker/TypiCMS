<?php

use Mockery as m;

class FilterTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->log = m::mock('Illuminate\Log\Writer');
        $this->filter = m::mock('Basset\Filter\Filter', array($this->log, 'FooFilter', array(), 'testing'))->shouldDeferMissing();
        $this->filter->setResource($this->resource = m::mock('Basset\Filter\Filterable'));
    }


    public function testSettingOfFilterInstantiationArguments()
    {
        $this->filter->setArguments('bar', 'baz');

        $arguments = $this->filter->getArguments();

        $this->assertEquals(array('bar', 'baz'), $arguments);
    }


    public function testSettingOfFilterInstantiationArgumentsOverwritesExistingArguments()
    {
        $this->filter->setArguments('foo', 'bar');
        $this->filter->setArguments('baz');

        $arguments = $this->filter->getArguments();

        $this->assertEquals(array('baz'), $arguments);
    }


    public function testSettingFilterEnvironmentRequirement()
    {
        $this->filter->whenEnvironmentIs('testing');
        $this->assertTrue($this->filter->processRequirements());
    }


    public function testSettingFilterStylesheetGroupRestrictionRequirement()
    {
        $this->resource->shouldReceive('isStylesheet')->once()->andReturn(false);
        $this->filter->whenAssetIsStylesheet();
        $this->assertFalse($this->filter->processRequirements());
    }


    public function testSettingFilterJavascriptGroupRestrictionRequirement()
    {
        $this->resource->shouldReceive('isJavascript')->once()->andReturn(true);
        $this->filter->whenAssetIsJavascript();
        $this->assertTrue($this->filter->processRequirements());
    }


    public function testSettingAssetNameIsRequirement()
    {
        $this->resource->shouldReceive('getRelativePath')->times(3)->andReturn('foo/bar.css');

        $this->filter->whenAssetIs('.*\.css');
        $this->assertTrue($this->filter->processRequirements());

        $this->filter->whenAssetIs('foo/baz.css');
        $this->assertFalse($this->filter->processRequirements());
    }


    public function testSettingClassExistsFilterRequirement()
    {
        $this->filter->whenClassExists('FilterTest');
        $this->assertTrue($this->filter->processRequirements());

        $this->filter->whenClassExists('FooBarBaz');
        $this->assertFalse($this->filter->processRequirements());
    }


    public function testSettingProductionBuildFilterRequirement()
    {
        $this->filter->whenProductionBuild();
        $this->assertFalse($this->filter->processRequirements());

        $this->filter->setProduction(true);
        $this->assertTrue($this->filter->processRequirements());
    }


    public function testSettingDevelopmentBuildFilterRequirement()
    {
        $this->filter->whenDevelopmentBuild();
        $this->assertTrue($this->filter->processRequirements());

        $this->filter->setProduction(true);
        $this->assertFalse($this->filter->processRequirements());
    }


    public function testSettingCustomFilterRequirement()
    {
        $this->resource->shouldReceive('fooBar')->times(3)->andReturn(true, true, false);

        $this->filter->when(function($asset)
        {
            return $asset->fooBar();
        });
        $this->assertTrue($this->filter->processRequirements());

        $this->filter->when(function($asset)
        {
            return $asset->fooBar();
        });
        $this->assertFalse($this->filter->processRequirements());
    }


    public function testInstantiationOfFiltersWithNoArguments()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterStub');
        $instance = $this->filter->getInstance();
        $this->assertInstanceOf('FilterStub', $instance);
    }


    public function testInstantiationOfFiltersWithArguments()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $this->filter->setArguments('bar');
        $instance = $this->filter->getInstance();
        $this->assertEquals('bar', $instance->getFooBin());
    }


    public function testInstantiationOfFiltersWithBeforeFilteringCallback()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterStub');
        $this->filter->beforeFiltering(function($filter)
        {
            $filter->setFooBin('bar');
        });
        $instance = $this->filter->getInstance();
        $this->assertEquals('bar', $instance->getFooBin());
    }


    public function testInvalidMethodsAreHandledByResource()
    {
        $filter = new Basset\Filter\Filter($this->log, 'FooFilter', array(), 'testing');
        $filter->setResource($this->resource);
        $this->resource->shouldReceive('foo')->once()->andReturn('bar');
        $this->assertEquals('bar', $filter->foo());
    }


    public function testFindingOfMissingConstructorArgsWithInvalidClassReturnsCurrentInstance()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn(null);
        $this->assertEquals($this->filter, $this->filter->findMissingConstructorArgs());
    }


    public function testFindingOfMissingConstructorArgsSkipsExistingArgument()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $this->filter->shouldReceive('getExecutableFinder')->once()->andReturn(m::mock('Symfony\Component\Process\ExecutableFinder'));
        $this->filter->setArguments('foo');
        $this->filter->findMissingConstructorArgs();
        $this->assertContains('foo', $this->filter->getArguments());
    }


    public function testFindingOfMissingConstructorArgsViaEnvironmentVariable()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $this->filter->shouldReceive('getExecutableFinder')->once()->andReturn(m::mock('Symfony\Component\Process\ExecutableFinder'));
        $this->filter->shouldReceive('getEnvironmentVariable')->once()->with('foo_bin')->andReturn('path/to/foo/bin');
        $this->filter->findMissingConstructorArgs();
        $this->assertContains('path/to/foo/bin', $this->filter->getArguments());
    }


    public function testFindingOfMissingConstructorArgsViaExecutableFinder()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $this->filter->shouldReceive('getExecutableFinder')->once()->andReturn($finder = m::mock('Symfony\Component\Process\ExecutableFinder'));
        $finder->shouldReceive('find')->once()->with('foo')->andReturn('path/to/foo/bin');
        $this->filter->findMissingConstructorArgs();
        $this->assertContains('path/to/foo/bin', $this->filter->getArguments());
    }


    public function testFindingOfMissingConstructorArgsSetsFilterNodePaths()
    {
        $filter = m::mock('Basset\Filter\Filter', array($this->log, 'FooFilter', array('path/to/node'), 'testing'))->shouldDeferMissing();
        $filter->setResource($this->resource);
        $filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $filter->shouldReceive('getExecutableFinder')->once()->andReturn($finder = m::mock('Symfony\Component\Process\ExecutableFinder'));
        $filter->shouldReceive('getEnvironmentVariable')->once()->with('foo_bin')->andReturn('path/to/foo/bin');
        $filter->findMissingConstructorArgs();
        $this->assertContains(array('path/to/node'), $filter->getArguments());
    }


    public function testFindingOfMissingConstructorArgsIgnoresFilterWithInvalidExecutables()
    {
        $this->log->shouldReceive('error')->once();
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterWithConstructorStub');
        $this->filter->shouldReceive('getExecutableFinder')->once()->andReturn($finder = m::mock('Symfony\Component\Process\ExecutableFinder'));
        $finder->shouldReceive('find')->once()->with('foo')->andReturn(false);
        $this->filter->findMissingConstructorArgs();
        $this->assertTrue($this->filter->isIgnored());
    }


    public function testFindingOfMissingConstructorArgsIsSkippedWhenNoConstructorPresent()
    {
        $this->filter->shouldReceive('getClassName')->once()->andReturn('FilterStub');
        $this->filter->findMissingConstructorArgs();
        $this->assertEmpty($this->filter->getArguments());
    }


}


class FilterStub {

    protected $fooBin;

    public function setFooBin($fooBin)
    {
        $this->fooBin = $fooBin;
    }

    public function getFooBin()
    {
        return $this->fooBin;
    }

}


class FilterWithConstructorStub {

    protected $fooBin;

    public function __construct($fooBin, $nodePaths = array())
    {
        $this->fooBin = $fooBin;
    }

    public function getFooBin()
    {
        return $this->fooBin;
    }

}