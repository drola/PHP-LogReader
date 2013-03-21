<?php

namespace Drola\LogReader;

class ApacheErrorLogReader extends AbstractFileReader
{
    protected function parseLine($line) {
        return $line;
    }
}