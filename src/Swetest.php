<?php

/**
 * This file is part of DestinyLab.
 */

namespace DestinyLab;

/**
 * Swetest
 *
 * @package DestinyLab
 * @author Lance He <indigofeather@gmail.com>
 */
class Swetest
{
    protected $path = null;
    protected $query = null;
    protected $output = [];
    protected $status = null;
    protected $hasOutput = false;
    protected $maskPath = true;
    protected $lastQuery = null;

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
        $this->maskPath and $this->output[0] = str_replace($this->path, '***-***', $this->output[0]);
        $this->hasOutput = true;
        $this->lastQuery = $this->query;

        return $this;
    }

    /**
     * @param $needMask
     * @return $this
     */
    public function maskPath($needMask)
    {
        $this->maskPath = (bool) $needMask;

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

    /**
     * @return string|null
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }
}
