<?php

namespace DestinyLab;

/**
 * Class Swetest
 *
 * @package DestinyLab
 */
class Swetest
{
    protected $path = null;
    protected $query = null;
    protected $output = [];
    protected $status = null;
    protected $hasOutput = false;

    public function __construct($path = null)
    {
        // default path
        $path === null and $path = __DIR__.'/../resources/';
        $this->setPath($path);
    }

    /**
     * @param $path
     * @return $this
     * @throws SwetestException
     */
    public function setPath($path)
    {
        if (is_dir($path) and is_file($path.'swetest')) {
            $this->path = $path;
        } else {
            throw new SwetestException('Invalid path!');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $query string
     * @return $this
     */
    public function query($query)
    {
        $this->query = $this->getPath().'swetest -edir'.$this->getPath().' '.$query;

        return $this;
    }

    /**
     * @return $this
     * @throws SwetestException
     */
    public function execute()
    {
        if ($this->query === null) {
            throw new SwetestException('No query!');
        }

        exec($this->query, $this->output, $this->status);
        $this->output[0] = str_replace($this->path, '', $this->output[0]);
        $this->hasOutput = true;

        return $this;
    }

    /**
     * @return array
     * @throws SwetestException
     */
    public function response()
    {
        if ($this->hasOutput === false) {
            throw new SwetestException('Need `execute()` before call this method!');
        }

        return [
            'status' => $this->getStatus(),
            'output' => $this->getOutput(),
        ];
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
