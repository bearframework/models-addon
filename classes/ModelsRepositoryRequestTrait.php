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
