<?php

namespace Drola\LogReader;

class ReaderFactory
{
    public static function getReader($filename, $type)
    {
        switch($type) {
        case 'apache/error.log':
            return new ApacheErrorLogReader($filename);
            break;
        }

        throw new InvalidArgumentException(printf("Reader of type '%s' does not exist", $ype));
    }
}