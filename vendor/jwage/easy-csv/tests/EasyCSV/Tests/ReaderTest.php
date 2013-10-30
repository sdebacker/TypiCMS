<?php

namespace EasyCSV\Tests;

use EasyCSV\Reader;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getReaders
     */
    public function testOneAtAtime(Reader $reader)
    {
        while($row = $reader->getRow()) {
            $this->assertTrue(is_array($row));
            $this->assertEquals(3, count($row));
        }
    }

    /**
     * @dataProvider getReaders
     */
    public function testGetAll(Reader $reader)
    {
        $this->assertEquals(5, count($reader->getAll()));
    }

    /**
     * @dataProvider getReaders
     */
    public function testGetHeaders(Reader $reader)
    {
        $this->assertEquals(array("column1", "column2", "column3"), $reader->getHeaders());
    }
    
    public function getReaders()
    {
        $readerSemiColon = new \EasyCSV\Reader(__DIR__ . '/read_sc.csv');
        $readerSemiColon->setDelimiter(';');
        return array(
            array(new \EasyCSV\Reader(__DIR__ . '/read.csv')),
            array($readerSemiColon),
        );
    }
}
