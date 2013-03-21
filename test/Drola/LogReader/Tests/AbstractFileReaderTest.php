<?php

namespace Drola\LogReader\Tests;

use Drola\LogReader\AbstractFileReader;

class AbstractFileReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testForwardRead()
    {
        $stub = $this->getMockForAbstractClass('Drola\LogReader\AbstractFileReader', array(dirname(__FILE__).'/lines.txt', false));
        $stub->expects($this->any())
            ->method('parseLine')
            ->will($this->returnArgument(0));
        
        $lines = array("Line 1\n", "Line 2\n", "Line 3\n", "Line 4\n");
        $i = 0;
        foreach ($stub as $k=>$v) {
            $this->assertEquals($i, $k, "Keys don't match");
            $this->assertEquals($lines[$i], $v);
            $i++;
        }
        $this->assertEquals(4, $i, "Expecting to read 4 lines");
    }

    public function testBackwardRead()
    {
        $stub = $this->getMockForAbstractClass('Drola\LogReader\AbstractFileReader', array(dirname(__FILE__).'/lines.txt', true));
        $stub->expects($this->any())
            ->method('parseLine')
            ->will($this->returnArgument(0));
        
        $lines = array_reverse(array("Line 1\n", "Line 2\n", "Line 3\n", "Line 4\n"));
        $i = 0;
        foreach ($stub as $k=>$v) {
            $this->assertEquals($i, $k, "Keys don't match");
            $this->assertEquals($lines[$i], $v);
            $i++;
        }
        $this->assertEquals(4, $i, "Expecting to read 4 lines");
    }
}