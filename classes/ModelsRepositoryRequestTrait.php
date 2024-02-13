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
trait ModelsRepositoryRequestTrait
{

    /**
     * 
     * @param string $id
     * @return object|null
     */
    public function get(string $id)
    {
        if (isset($this->internalModelsRepositorySources)) {
            $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
            $sourcesModelsList = $this->internalModelsRepositoryGetSourcesModelsList();
            foreach ($sourcesModelsList as $sourcesModel) {
                if (isset($sourcesModel->$modelIDProperty) && $sourcesModel->$modelIDProperty === $id) {
                    return $sourcesModel;
                }
            }
        }
        $json = $this->internalModelsRepositoryGetDataDriver()->get($id);
        if ($json === null) {
            return null;
        }
        return $this->internalModelsRepositoryMakeFromJSON($json);
    }

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function exists(string $id): bool
    {
        if (isset($this->internalModelsRepositorySources)) {
            $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
            $sourcesModelsList = $this->internalModelsRepositoryGetSourcesModelsList();
            foreach ($sourcesModelsList as $sourcesModel) {
                if (isset($sourcesModel->$modelIDProperty) && $sourcesModel->$modelIDProperty === $id) {
                    return true;
                }
            }
        }
        return $this->internalModelsRepositoryGetDataDriver()->exists($id);
    }

    /**
     * 
     * @return \BearFramework\Models\ModelsList
     */
    public function getList(): \BearFramework\Models\ModelsList
    {
        return $this->internalModelsRepositoryGetList();
    }
}
