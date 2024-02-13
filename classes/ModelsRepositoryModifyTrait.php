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
        if (isset($this->internalModelsRepositorySources)) {
            $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
            $sourcesModelsList = $this->internalModelsRepositoryGetSourcesModelsList();
            foreach ($sourcesModelsList as $sourcesModel) {
                if (isset($sourcesModel->$modelIDProperty) && isset($model->$modelIDProperty) && $sourcesModel->$modelIDProperty === $model->$modelIDProperty) {
                    throw new \Exception('Cannot set a model (' . $modelIDProperty . '=' . $model->$modelIDProperty . ') defined in addSource()');
                }
            }
        }
        $this->internalModelsRepositorySet($model);
    }

    /**
     * 
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        if (isset($this->internalModelsRepositorySources)) {
            $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
            $sourcesModelsList = $this->internalModelsRepositoryGetSourcesModelsList();
            foreach ($sourcesModelsList as $sourcesModel) {
                if (isset($sourcesModel->$modelIDProperty) && $sourcesModel->$modelIDProperty === $id) {
                    throw new \Exception('Cannot delete a model (' . $modelIDProperty . '=' . $id . ') defined in addSource()');
                }
            }
        }
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
