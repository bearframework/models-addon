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
     * @var string|null
     */
    private $dataKeyCallback = null;

    /**
     *
     * @var \BearFramework\App 
     */
    private $app = null;

    /**
     * 
     * @param string $dataKeyPrefix
     * @param callable|null $dataKeyCallback
     * @throws \InvalidArgumentException
     */
    public function __construct(string $dataKeyPrefix, ?callable $dataKeyCallback = null)
    {
        $this->app = App::get();
        if (strlen($dataKeyPrefix) === 0 || !$this->app->data->validate($dataKeyPrefix . 'example')) {
            throw new \InvalidArgumentException('The dataKeyPrefix provided (' . $dataKeyPrefix . ') is not valid!');
        }
        $this->dataKeyPrefix = $dataKeyPrefix;
        $this->dataKeyCallback = $dataKeyCallback;
    }

    /**
     * 
     * @param string $id
     * @return string
     */
    private function getDataKey(string $id): string
    {
        if ($this->dataKeyCallback !== null) {
            return call_user_func($this->dataKeyCallback, $id);
        }
        return md5($id) . '.json';
    }

    /**
     * 
     * @param string $id
     * @param string $json
     * @return void
     */
    public function set(string $id, string $json): void
    {
        $this->app->data->setValue($this->dataKeyPrefix . $this->getDataKey($id), $json);
    }

    /**
     * 
     * @param string $id
     * @return string|null
     */
    public function get(string $id): ?string
    {
        return $this->app->data->getValue($this->dataKeyPrefix . $this->getDataKey($id));
    }

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool
    {
        return $this->app->data->exists($this->dataKeyPrefix . $this->getDataKey($id));
    }

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->app->data->delete($this->dataKeyPrefix . $this->getDataKey($id));
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
            ->sliceProperties(['key', 'value']); // Key is requested, because there is a bug when applying the filters multiple times.
        foreach ($list as $item) {
            $result[] = $item['value'];
        }
        return $result;
    }
}
