<?php

use Drola\LogReader\ApacheErrorLogReader;

class ApacheErrorLogReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testParsing() {
        $reader = new ApacheErrorLogReader(dirname(__FILE__).'/error.log', false);
        $lines = array(
            array(
                'datetime' => new \DateTime("Thu Mar 21 22:11:54 2013"),
                'severity' => 'error',
                'client' => null,
                'message' => "(9)Bad file descriptor: apr_socket_accept: (client socket) apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.1.1 for ServerName"
                ),
            array(
                'datetime' => new \DateTime("Tue Feb 28 14:34:41 2012"),
                'severity' => 'notice',
                'client' => '192.168.50.10',
                'message' => 'Symbolic link not allowed or link target not accessible: /usr/local/apache2/htdocs/x.js'
                )
            );

        foreach ($reader as $k=>$l) {
            $this->assertEquals($lines[$k], $l);
        }
    }
}