<?php

namespace Drola\LogReader;

abstract class AbstractFileReader implements ReaderInterface
{
    protected $backwards;
    protected $fh;
    protected $key = 0;
    protected $current = null;
    protected $pos = 0;

    public function __construct($filename, $backwards = true)
    {
        $this->fh = fopen($filename, "r");
        if (!$this->fh) {
            throw new \Exception(sprintf("Cannot open %s", $filename));
        }
        $this->backwards = $backwards;
        $this->rewind();
    }
    
    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
    {
        if ($this->backwards) {
            $line = $this->nextBck();
        } else {
            $line = $this->nextFwd();
        }

        if ($line) {
            $this->key++;
            $this->current = $this->parseLine($line);
        } else {
            $this->current = null;
        } 
    }

    protected function nextFwd()
    {
        return fgets($this->fh);
    }

    protected function nextBck()
    {
        if ($this->pos == 0) {
            return false;
        }

        //find next newline
        $this->pos--;
        while ($this->pos >= 0) {
            $this->pos--;
            fseek($this->fh, $this->pos, SEEK_SET);
            if (fgetc($this->fh) == "\n") {
                break;
            }
        }

        fseek($this->fh, $this->pos+1, SEEK_SET);

        return fgets($this->fh);
    }

    public function rewind()
    {
        if ($this->backwards) {
            fseek($this->fh, 0, SEEK_END);
        } else {
            fseek($this->fh, 0, SEEK_SET);
        }
        
        $this->pos = ftell($this->fh);
        $this->key = -1;
        $this->next();
    }

    public function valid()
    {
        return $this->current != null;
    }

    abstract protected function parseLine($line);
}