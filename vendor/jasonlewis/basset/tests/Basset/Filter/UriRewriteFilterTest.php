<?php

use Assetic\Asset\StringAsset;
use Basset\Filter\UriRewriteFilter;

class UriRewriteFilterTest extends FilterTestCase {


    public function testUriRewrite()
    {
        $filter = new UriRewriteFilter('path/to/public');

        $input = "body { background-image: url('../foo/bar.png'); }";

        $asset = new StringAsset($input, array(), 'path/to/public/baz', 'qux.css');
        $asset->load();

        $filter->filterDump($asset);

        $this->assertEquals("body { background-image: url('/foo/bar.png'); }", $asset->getContent());
    }


    public function testUriRewriteWithSymlinks()
    {
        $filter = new UriRewriteFilter('path/to/public', array('//assets' => strtr('path/to/outside/public/assets', '/', DIRECTORY_SEPARATOR)));

        $input = "body { background-image: url('../foo/bar.png'); }";

        $asset = new StringAsset($input, array(), 'path/to/outside/public/assets/baz', 'qux.css');
        $asset->load();

        $filter->filterDump($asset);

        $this->assertEquals("body { background-image: url('/assets/foo/bar.png'); }", $asset->getContent());
    }


}