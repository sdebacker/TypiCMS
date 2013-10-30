<?php

namespace EasyCSV\Tests;

class WriterTest extends \PHPUnit_Framework_TestCase
{
    private $writer;

    public function setUp()
    {
        $this->writer = new \EasyCSV\Writer(__DIR__ . '/write.csv');
    }

    public function testWriteRow()
    {
        $this->writer->writeRow('test1, test2, test3');
    }

    public function testWriteFromArray()
    {
        $this->writer->writeRow('column1, column2, column3');
        $this->writer->writeFromArray(array(
            '1test1, 1test2ing this out, 1test3',
            array('2test1', '2test2 ing this out ok', '2test3')
        ));
    }

    public function testReadWrittenFile()
    {
        $reader = new \EasyCSV\Reader(__DIR__ . '/write.csv');
        $results = $reader->getAll();
        $expected = array(
            array(
                'column1' => '1test1',
                'column2' => '1test2ing this out',
                'column3' => '1test3'
            ),
            array(
                'column1' => '2test1',
                'column2' => '2test2 ing this out ok',
                'column3' => '2test3'
            )
        );
        $this->assertEquals($expected, $results);
    }
}
