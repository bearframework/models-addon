<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 *
 */
class ModelsRepository
{

    private $data = [];
    private $internalData = [];

    /**
     * 
     * @return \BearFramework\Models\modelClassName
     */
    public function make()
    {
        $modelClassName = $this->getModelClassName();
        return new $modelClassName();
    }

    /**
     * 
     * @param string $name
     */
    protected function setModel(string $name)
    {
        $this->internalData[0] = $name;
    }

    /**
     * 
     * @return type
     * @throws \Exception
     */
    private function getModelClassName()
    {
        $className = isset($this->internalData[0]) ? $this->internalData[0] : null;
        if ($className !== null && class_exists($className)) {
            return $className;
        } else {
            throw new \Exception('Cannot find class named ' . $className . '!');
        }
    }

    /**
     * 
     * @param type $name
     */
    protected function setDataStorage($name)
    {
        
    }

    /**
     * 
     * @param \BearFramework\Models\Model $model
     * @throws \Exception
     */
    public function set(\BearFramework\Models\Model $model)
    {
        $modelClassName = $this->getModelClassName();
        if (!is_a($model, $modelClassName)) {
            throw new \Exception('');
        }
        if ($model->key === null || !isset($model->key[0])) {
            $model->key = md5(uniqid('', true) . '-' . random_bytes(20)) . rand(10000000, 99999999);
        }
        $this->data[] = $model;
    }

    /**
     * 
     * @param string $key
     * @return \BearFramework\Models\Model
     */
    public function get(string $key): \BearFramework\Models\Model//?
    {
        $list = $this->getList()->filterBy('key', $key);
        return isset($list[0]) ? $list[0] : null;
    }

    /**
     * 
     * @param string $key
     */
    public function exists(string $key)
    {
        
    }

    /**
     * 
     * @param string $key
     */
    public function delete(string $key)
    {
        
    }

    /**
     * 
     */
    public function deleteAll()
    {
        $this->data = [];
    }

    /**
     * 
     * @return \BearFramework\Models\ModelsList
     */
    public function getList(): \BearFramework\Models\ModelsList
    {
        return new \BearFramework\Models\ModelsList(function () {
            $result = [];
            foreach ($this->data as $object) {
                $result[] = clone($object);
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
    function __fromArray(array $data): void
    {
        $modelClassName = $this->getModelClassName();
        foreach ($data as $item) {
            $this->set(call_user_func([$modelClassName, 'fromArray'], $item));
        }
    }

    /**
     * 
     * @param array $data
     * @return \BearFramework\Models\Model
     */
    static function fromArray(array $data)
    {
        $class = get_called_class();
        $object = new $class();
        $object->__fromArray($data);
        return $object;
    }

    /**
     * 
     * @param string $data
     */
    function __fromJSON(string $data): void
    {
        $data = json_decode($data, true);
        $modelClassName = $this->getModelClassName();
        foreach ($data as $item) {
            $this->set(call_user_func([$modelClassName, 'fromJSON'], json_encode($item)));
        }
    }

    /**
     * 
     * @param string $data
     * @return \BearFramework\Models\Model
     */
    static function fromJSON(string $data)
    {
        $class = get_called_class();
        $object = new $class();
        $object->__fromJSON($data);
        return $object;
    }

}
