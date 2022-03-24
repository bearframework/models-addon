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
        $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
        $modelsJSON = $this->internalModelsRepositoryGetDataDriver()->getAll();
        $class = $this->internalModelsRepositoryGetModelClassName();
        foreach ($modelsJSON as $modelJSON) {
            $model = call_user_func([$class, 'fromJSON'], $modelJSON);
            $this->delete($model->$modelIDProperty);
        }
    }
}
