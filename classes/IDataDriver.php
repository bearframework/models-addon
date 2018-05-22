<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 * A data driver interface.
 * @codeCoverageIgnore
 */
interface IDataDriver
{

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @param string $json
     */
    public function set(string $contextID, string $key, string $json): void;

    /**
     * 
     * @param string $contextID
     * @param string $key
     */
    public function get(string $contextID, string $key): ?string;

    /**
     * 
     * @param string $contextID
     * @param string $key
     */
    public function exists(string $contextID, string $key): bool;

    /**
     * 
     * @param string $contextID
     * @param string $key
     */
    public function delete(string $contextID, string $key): void;

    /**
     * 
     * @param string $contextID
     */
    public function deleteAll(string $contextID): void;

    /**
     * 
     * @param string $contextID
     */
    public function getKeys(string $contextID): array;
}
