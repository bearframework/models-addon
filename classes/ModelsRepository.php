<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 *
 */
class ModelsRepository
{

    private $data = [];

    public function make()
    {
        return new User();
    }

    protected function setModel($name)
    {
        
    }

    public function set(\BearFramework\App\Model $model)
    {
        $this->data[] = $model;
    }

    public function get(string $key): \BearFramework\App\Model//?
    {
        $list = $this->getList()->filterBy('id', $key);
        return isset($list[0]) ? $list[0] : null;
    }

    public function exists(string $key)
    {
        
    }

    public function delete(string $key)
    {
        
    }

    public function getList(): \BearFramework\App\ModelsList
    {
        return new \BearFramework\App\ModelsList(function () {
            return $this->data;
        });
    }

    public function toArray()
    {
        return $this->getList()->toArray();
    }

    public function toJSON()
    {
        return $this->getList()->toJSON();
    }

}
