<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
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
     * @var \BearFramework\App 
     */
    private $app = null;

    /**
     * 
     * @param string $dataKeyPrefix
     * @throws \InvalidArgumentException
     */
    public function __construct(string $dataKeyPrefix)
    {
        $this->app = App::get();
        if (strlen($dataKeyPrefix) === 0 || !$this->app->data->isValidKey($dataKeyPrefix . 'example')) {
            throw new \InvalidArgumentException('The dataKeyPrefix provided (' . $dataKeyPrefix . ') is not valid!');
        }
        $this->dataKeyPrefix = $dataKeyPrefix;
    }

    /**
     * 
     * @param string $id
     * @param string $json
     * @return void
     */
    public function set(string $id, string $json): void
    {
        $this->app->data->setValue($this->dataKeyPrefix . md5($id) . '.json', $json);
    }

    /**
     * 
     * @param string $id
     * @return string|null
     */
    public function get(string $id): ?string
    {
        return $this->app->data->getValue($this->dataKeyPrefix . md5($id) . '.json');
    }

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool
    {
        return $this->app->data->exists($this->dataKeyPrefix . md5($id) . '.json');
    }

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->app->data->delete($this->dataKeyPrefix . md5($id) . '.json');
    }

    /**
     * 
     * @return void
     */
    public function deleteAll(): void
    {
        $list = $this->app->data->getList()
                ->filterBy('key', $this->dataKeyPrefix, 'startWith')
                ->sliceProperties(['key']);
        foreach ($list as $item) {
            $this->app->data->delete($item->key);
        }
    }

    /**
     * 
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        $list = $this->app->data->getList()
                ->filterBy('key', $this->dataKeyPrefix, 'startWith')
                ->sliceProperties(['value']);
        foreach ($list as $item) {
            $result[] = $item->value;
        }
        return $result;
    }

}
