<?php

use Basset\Filter\CssoFilter;
use Assetic\Asset\StringAsset;
use Assetic\Exception\FilterException;

class CssoFilterTest extends FilterTestCase {


    private $filter;


    public function setUp()
    {
        $cssoBin = $this->findExecutable('csso', 'CSSO_BIN');
        $nodeBin = $this->findExecutable('node', 'NODE_BIN');

        if ( ! $cssoBin or ! $nodeBin)
        {
            $this->markTestIncomplete('Could not find CSSO or Node executables.');
        }

        $this->filter = new CssoFilter($cssoBin, $nodeBin);
    }


    public function tearDown()
    {
        $this->filter = null;
    }


    public function testCsso()
    {
        $input = '.test { height: 10px; height: 20px; }';

        $asset = new StringAsset($input);
        $asset->load();

        try
        {
            $this->filter->filterLoad($asset);
        }
        catch (FilterException $e)
        {
            $this->markTestIncomplete('Could not properly test CSSO filter. Make sure Node and CSSO are in your PATH.');
        }

        $this->assertEquals('.test{height:20px}', $asset->getContent());
    }


}