<?php

namespace Drola\LogReader;

class ApacheErrorLogReader extends AbstractFileReader
{
    protected function parseLine($line) {
        /**
         * Regex by drew010 @ Stack Overflow, http://stackoverflow.com/a/7603165
         */
        $regex = '/^\[([^\]]+)\] \[([^\]]+)\] (?:\[client ([^\]]+)\])?\s*(.*)$/i';
        preg_match($regex, $line, $matches);
        return array(
            'datetime' => new \DateTime($matches[1]),
            'severity' => $matches[2],
            'client' => $matches[3],
            'message' => $matches[4]
            );
    }
}