<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 * 
 */
trait ModelsRepositoryCreateTrait
{

    /**
     * 
     * @var boolean
     */
    protected $internalModelsRepositoryUseLock = true;

    /**
     * 
     * @var callable|null
     * @return void
     */
    private $idGenerator = null;

    /**
     * 
     * @param callable $callback
     * @return void
     */
    protected function setIDGenerator(callable $callback): void
    {
        $this->idGenerator = $callback;
    }

    /**
     * 
     * @param integer $length
     * @return string
     */
    protected function generateID(int $length = 15): string
    {
        $result = '';
        $s = "qwertyuiopasdfghjklzxcvbnm1234567890";
        $n = strlen($s);
        while ($length > 0) {
            $i = rand(0, $n - 1);
            $result .= substr($s, $i, 1);
            $length--;
        }
        return $result;
    }

    /**
     * 
     * @param object $model
     * @return string
     * @throws \InvalidArgumentException
     */
    public function add($model): string
    {
        return $this->internalModelsRepositoryAdd($model, $this->idGenerator !== null ? $this->idGenerator : function () {
            return $this->generateID();
        });
    }
}
