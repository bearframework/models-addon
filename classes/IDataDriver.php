<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 * A data driver interface.
 * 
 * @codeCoverageIgnore
 */
interface IDataDriver
{

    /**
     * 
     * @param string $id
     * @param string $json
     * @return void
     */
    public function set(string $id, string $json): void;

    /**
     * 
     * @param string $id
     * @return string|null
     */
    public function get(string $id): ?string;

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool;

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void;

    /**
     * 
     * @return array
     */
    public function getAll(): array;
}
