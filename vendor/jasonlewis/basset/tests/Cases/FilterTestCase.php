<?php

use Symfony\Component\Process\ExecutableFinder;

/**
 * Filter test case inspired by Assetic's filter test case.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the Assetic source code.
 * 
 * @copyright 2010 - 2013 OpenSky Project Inc
 * @author OpenSky Project Inc
 */
class FilterTestCase extends PHPUnit_Framework_TestCase {


    protected function findExecutable($name, $server = null)
    {
        if ( ! is_null($server) and isset($_SERVER[$server]))
        {
            return $_SERVER[$server];
        }

        $finder = new ExecutableFinder;

        return $finder->find($name);
    }


}