<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
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
     * @param string $id
     * @param string $json
     * @return void
     */
    public function set(string $id, string $json): void
    {
        $this->data[$id] = $json;
    }

    /**
     * 
     * @param string $id
     * @return string|null
     */
    public function get(string $id): ?string
    {
        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool
    {
        return isset($this->data[$id]);
    }

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        if (isset($this->data[$id])) {
            unset($this->data[$id]);
        }
    }

    /**
     * 
     * @return void
     */
    public function deleteAll(): void
    {
        $this->data = [];
    }

    /**
     * 
     * @return array
     */
    public function getAll(): array
    {
        return array_values($this->data);
    }

}
