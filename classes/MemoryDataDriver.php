<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 * A memory based data driver
 */
class MemoryDataDriver implements \BearFramework\Models\IDataDriver
{

    /**
     *
     * @var array
     */
    private $data = [];

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @param string $json
     */
    public function set(string $contextID, string $key, string $json): void
    {
        if (!isset($this->data[$contextID])) {
            $this->data[$contextID] = [];
        }
        $this->data[$contextID][$key] = $json;
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @return string
     */
    public function get(string $contextID, string $key): ?string
    {
        return isset($this->data[$contextID], $this->data[$contextID][$key]) ? $this->data[$contextID][$key] : null;
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @return bool
     */
    public function exists(string $contextID, string $key): bool
    {
        return isset($this->data[$contextID], $this->data[$contextID][$key]);
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     */
    public function delete(string $contextID, string $key): void
    {
        if (isset($this->data[$contextID], $this->data[$contextID][$key])) {
            unset($this->data[$contextID][$key]);
        }
    }

    /**
     * 
     * @param string $contextID
     */
    public function deleteAll(string $contextID): void
    {
        if (isset($this->data[$contextID])) {
            unset($this->data[$contextID]);
        }
    }

    /**
     * 
     * @param string $contextID
     * @return array
     */
    public function getKeys(string $contextID): array
    {
        return isset($this->data[$contextID]) ? array_keys($this->data[$contextID]) : [];
    }

}
