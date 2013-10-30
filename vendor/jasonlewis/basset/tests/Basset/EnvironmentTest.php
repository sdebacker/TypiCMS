<?php

use Mockery as m;
use Basset\Environment;

class EnvironmentTest extends PHPUnit_Framework_TestCase {


    public function tearDown()
    {
        m::close();
    }


    public function setUp()
    {
        $this->finder = m::mock('Basset\AssetFinder');
        $this->finder->shouldReceive('setWorkingDirectory')->with('/')->andReturn('/');

        $this->environment = new Environment(m::mock('Basset\Factory\FactoryManager'), $this->finder);
    }


    public function testMakingNewCollectionReturnsNewCollectionInstance()
    {
        $this->assertInstanceOf('Basset\Collection', $this->environment->collection('foo'));
    }


    public function testMakingNewCollectionFiresCallback()
    {
        $fired = false;

        $this->environment->collection('foo', function() use (&$fired) { $fired = true; });
        $this->assertTrue($fired);
    }


    public function testRegisterPackageNamespaceAndVendorWithEnvironmentAndFinder()
    {
        $this->finder->shouldReceive('addNamespace')->once()->with('bar', 'foo/bar');
        $this->environment->package('foo/bar', 'bar');
    }


    public function testRegisterPackageNamespaceAndVendorWithEnvironmentAndFinderAndGuessNamespace()
    {
        $this->finder->shouldReceive('addNamespace')->once()->with('bar', 'foo/bar');
        $this->environment->package('foo/bar');
    }


    public function testRegisteringArrayOfCollections()
    {
        $this->environment->collections(array(
            'foo' => function(){},
            'bar' => function(){}
        ));
        $this->assertCount(2, $this->environment->all());
        $this->assertArrayHasKey('foo', $this->environment->all());
    }


    public function testCheckingIfEnvironmentHasCollection()
    {
        $this->assertFalse($this->environment->has('foo'));
        $this->environment->collection('foo');
        $this->assertTrue($this->environment->has('foo'));
    }


}