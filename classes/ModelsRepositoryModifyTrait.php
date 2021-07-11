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
trait ModelsRepositoryModifyTrait
{

    /**
     * 
     * @param object $model
     * @return void
     * @throws \InvalidArgumentException
     */
    public function set($model): void
    {
        $this->internalModelsRepositorySet($model);
    }

    /**
     * 
     * @param object $model
     * @return string
     * @throws \InvalidArgumentException
     */
    public function add($model): string
    {
        return $this->internalModelsRepositoryAdd($model);
    }

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->internalModelsRepositoryGetDataDriver()->delete($id);
    }

    /**
     * 
     * @return void
     */
    public function deleteAll(): void
    {
        $this->internalModelsRepositoryGetDataDriver()->deleteAll();
    }
}
