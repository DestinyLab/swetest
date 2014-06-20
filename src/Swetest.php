<?php

/**
 * This file is part of DestinyLab.
 */

namespace DestinyLab;

/**
 * Swetest
 *
 * @package DestinyLab
 * @author  Lance He <indigofeather@gmail.com>
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

    /**
     * @param string $path
     * @throws SwetestException
     */
    public function __construct($path = null)
    {
        // default path
        $path === null and $path = __DIR__.'/../resources/';
        $this->setPath($path);
    }

    /**
     * @param $query string
     * @return $this
     */
    public function query($query)
    {
        is_array($query) and $query = $this->compile($query);
        $this->query = $this->getPath().'swetest -edir'.$this->getPath().' '.$query;

        return $this;
    }

    /**
     * @param $arr
     * @return string
     */
    public function compile($arr)
    {
        $options = [];
        foreach ($arr as $key => $value) {
            $options[] = is_int($key) ? '-'.$value : '-'.$key.$value;
        }

        return implode(' ', $options);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * @return $this
     * @throws SwetestException
     */
    public function execute()
    {
        if ($this->query === null) {
            throw new SwetestException('No query!');
        }

        exec($this->query, $output, $status);
        $this->output = $output;
        $this->status = $status;
        if ($this->maskPath) {
            $this->maskPath($this->output[0]);
            $this->maskPath($this->query);
        }

        $this->hasOutput = true;
        $this->lastQuery = $this->query;

        return $this;
    }

    /**
     * @param $path
     */
    protected function maskPath(&$path)
    {
        $path = str_replace($this->path, '***-***', $path);
    }

    /**
     * @param $needMask
     * @return $this
     */
    public function setMaskPath($needMask)
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
     * @return int
     * @throws SwetestException
     */
    public function getStatus()
    {
        if ($this->hasOutput === false) {
            throw new SwetestException('Need `execute()` before call this method!');
        }

        return $this->status;
    }

    /**
     * @return array
     * @throws SwetestException
     */
    public function getOutput()
    {
        if ($this->hasOutput === false) {
            throw new SwetestException('Need `execute()` before call this method!');
        }

        return $this->output;
    }

    /**
     * @return string|null
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }
}
