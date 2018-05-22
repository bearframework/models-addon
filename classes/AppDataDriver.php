<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

use BearFramework\App;

/**
 * An application data based data driver
 */
class AppDataDriver implements \BearFramework\Models\IDataDriver
{

    /**
     *
     * @var string 
     */
    private $dataKeyPrefix = null;

    /**
     * 
     * @param string $dataKeyPrefix
     * @throws \InvalidArgumentException
     */
    public function __construct(string $dataKeyPrefix = 'models/')
    {
        $app = App::get();
        $this->dataKeyPrefix = trim($dataKeyPrefix, '/');
        if (strlen($this->dataKeyPrefix) === 0 || !$app->data->isValidKey($this->dataKeyPrefix . '/example')) {
            throw new \InvalidArgumentException('The dataKeyPrefix provided (' . $dataKeyPrefix . ') is invalid!');
        }
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @param string $json
     */
    public function set(string $contextID, string $key, string $json): void
    {
        $app = App::get();
        $app->data->setValue($this->dataKeyPrefix . $contextID . '-/' . $key, $json);
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @return string|null
     */
    public function get(string $contextID, string $key): ?string
    {
        $app = App::get();
        $value = $app->data->getValue($this->dataKeyPrefix . $contextID . '-/' . $key);
        if ($value !== null) {
            return $value;
        }
        return null;
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     * @return bool
     */
    public function exists(string $contextID, string $key): bool
    {
        $app = App::get();
        return $app->data->exists($this->dataKeyPrefix . $contextID . '-/' . $key);
    }

    /**
     * 
     * @param string $contextID
     * @param string $key
     */
    public function delete(string $contextID, string $key): void
    {
        $app = App::get();
        $app->data->delete($this->dataKeyPrefix . $contextID . '-/' . $key);
    }

    /**
     * 
     * @param string $contextID
     */
    public function deleteAll(string $contextID): void
    {
        $app = App::get();
        $keys = $this->getKeys($contextID);
        $dataKeyPrefix = $this->dataKeyPrefix . $contextID . '-/';
        foreach ($keys as $key) {
            $app->data->delete($dataKeyPrefix . $key);
        }
    }

    /**
     * 
     * @param string $contextID
     * @return array
     */
    public function getKeys(string $contextID): array
    {
        $app = App::get();
        $result = [];
        $dataKeyPrefix = $this->dataKeyPrefix . $contextID . '-/';
        $dataKeyPrefixLength = strlen($dataKeyPrefix);
        $list = $app->data->getList()
                ->filterBy('key', $dataKeyPrefix, 'startWith');
        foreach ($list as $item) {
            $result[] = substr($item->key, $dataKeyPrefixLength);
        }
        return $result;
    }

}
