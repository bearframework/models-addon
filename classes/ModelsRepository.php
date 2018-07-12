<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 * @property-read string $contextID
 */
class ModelsRepository
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectFromArrayTrait;
    use \IvoPetkov\DataObjectFromJSONTrait;

    /**
     *
     * @var ?\BearFramework\Models\IDataDriver 
     */
    private $dataDriver = null;

    /**
     *
     * @var ?string 
     */
    private $modelClassName = null;

    /**
     *
     * @var ?\BearFramework\Models\Model 
     */
    private $modelObjectCache = null;

    /**
     *
     * @var string
     */
    private $contextID = '/';

    /**
     * 
     */
    function __construct()
    {
        $this->defineProperty('contextID', [
            'type' => '?string',
            'readonly' => true,
            'get' => function() {
                return $this->contextID;
            }
        ]);
    }

    /**
     * 
     * @param string $name
     */
    protected function setModel(string $name): void
    {
        $this->modelClassName = $name;
    }

    /**
     * 
     * @param \BearFramework\Models\IDataDriver $driver
     */
    protected function setDataDriver(\BearFramework\Models\IDataDriver $driver): void
    {
        $this->dataDriver = $driver;
    }

    /**
     * 
     * @param string $dataKeyPrefix
     */
    protected function useAppDataDriver(string $dataKeyPrefix): void
    {
        $this->setDataDriver(new \BearFramework\Models\AppDataDriver($dataKeyPrefix));
    }

    /**
     * 
     */
    protected function useMemoryDataDriver(): void
    {
        $this->setDataDriver(new \BearFramework\Models\MemoryDataDriver());
    }

    /**
     * 
     * @return string
     * @throws \Exception
     */
    private function getModelClassName(): string
    {
        if ($this->modelClassName !== null) {
            if (class_exists($this->modelClassName)) {
                return $this->modelClassName;
            }
            throw new \Exception('Cannot find class named ' . $this->modelClassName . '!');
        }
        throw new \Exception('No model specified! Use setModel() in the repository constructor to specify one.');
    }

    private function getDataDriver(): \BearFramework\Models\IDataDriver
    {
        if ($this->dataDriver !== null) {
            return $this->dataDriver;
        }
        throw new \Exception('No data driver specified! Use useAppDataDriver() or useMemoryDataDriver() in the repository constructor to specify one.');
    }

    /**
     * 
     * @param string $name
     * @return \BearFramework\Models\ModelsRepository
     * @throws \InvalidArgumentException
     */
    public function makeContext(string $name): \BearFramework\Models\ModelsRepository
    {
        $validateName = function($name) {
            return $name !== '-' && preg_match("/^[a-z0-9\.\-\_]*$/", $name) === 1;
        };
        $currentContextID = $this->contextID;
        if ($name[0] === '/') {
            $parts = explode('/', $name);
            foreach ($parts as $part) {
                if (!$validateName($part)) {
                    throw new \InvalidArgumentException('');
                }
            }
            $this->contextID = implode('/', $parts);
        } else {
            if (!$validateName($name)) {
                throw new \InvalidArgumentException('');
            }
            $this->contextID = $currentContextID . $name . '/';
        }
        $clone = clone($this);
        $this->contextID = $currentContextID;
        return $clone;
    }

    /**
     * 
     * @return \BearFramework\Models\Model
     */
    public function make(): \BearFramework\Models\Model
    {
        if ($this->modelObjectCache === null) {
            $modelClassName = $this->getModelClassName();
            $this->modelObjectCache = new $modelClassName();
        }
        return clone($this->modelObjectCache);
    }

    /**
     * 
     * @param string $data
     * @return \BearFramework\Models\Model
     */
    public function makeFromJSON(string $data): \BearFramework\Models\Model
    {
        return call_user_func([$this->getModelClassName(), 'fromJSON'], $data);
    }

    /**
     * 
     * @param array $data
     * @return \BearFramework\Models\Model
     */
    public function makeFromArray(array $data): \BearFramework\Models\Model
    {
        return call_user_func([$this->getModelClassName(), 'fromArray'], $data);
    }

    /**
     * 
     * @param \BearFramework\Models\Model $model
     * @throws \InvalidArgumentException
     */
    public function set(\BearFramework\Models\Model $model): void
    {
        $modelClassName = $this->getModelClassName();
        if (!is_a($model, $modelClassName)) {
            throw new \InvalidArgumentException('');
        }
        if ($model->key === null || !isset($model->key[0])) {
            $model->key = base_convert(md5(uniqid('', true) . '-' . random_bytes(20)), 16, 35) . 'z1' . base_convert(md5(uniqid('', true) . '-' . random_bytes(20)), 16, 35);
        }
        $this->getDataDriver()->set($this->contextID, $model->key, $model->toJSON());
    }

    /**
     * 
     * @param string $key
     * @return ?\BearFramework\Models\Model
     */
    public function get(string $key): ?\BearFramework\Models\Model
    {
        $json = $this->getDataDriver()->get($this->contextID, $key);
        if ($json === null) {
            return null;
        }
        return $this->makeFromJSON($json);
    }

    /**
     * 
     * @param string $key
     */
    public function exists(string $key): bool
    {
        return $this->getDataDriver()->exists($this->contextID, $key);
    }

    /**
     * 
     * @param string $key
     */
    public function delete(string $key): void
    {
        $this->getDataDriver()->delete($this->contextID, $key);
    }

    /**
     * 
     */
    public function deleteAll(): void
    {
        $this->getDataDriver()->deleteAll($this->contextID);
    }

    /**
     * 
     * @return \BearFramework\Models\ModelsList
     */
    public function getList(): \BearFramework\Models\ModelsList
    {
        return new \BearFramework\Models\ModelsList(function () {
            $result = [];
            $keys = $this->getDataDriver()->getKeys($this->contextID);
            foreach ($keys as $key) {
                $result[] = function() use ($key) {
                    return $this->get($key);
                };
            }
            return $result;
        });
    }

    /**
     * 
     * @return array
     */
    public function toArray(): array
    {
        return $this->getList()->toArray();
    }

    /**
     * 
     * @return string
     */
    public function toJSON(): string
    {
        return $this->getList()->toJSON();
    }

    /**
     * 
     * @param array $data
     */
    public function __fromArray(array $data): void
    {
        $modelClassName = $this->getModelClassName();
        foreach ($data as $item) {
            $this->set(call_user_func([$modelClassName, 'fromArray'], $item));
        }
    }

    /**
     * 
     * @param string $data
     */
    public function __fromJSON(string $data): void
    {
        $data = json_decode($data, true);
        $modelClassName = $this->getModelClassName();
        foreach ($data as $item) {
            $this->set(call_user_func([$modelClassName, 'fromJSON'], json_encode($item)));
        }
    }

}
