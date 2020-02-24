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
trait ModelsRepositoryMakeTrait
{

    /**
     *
     * @internal
     * @var ?object 
     */
    private $internalModelsRepositoryModelObjectCache = null;

    /**
     * 
     * @return object
     */
    public function make()
    {
        if ($this->internalModelsRepositoryModelObjectCache === null) {
            $modelClassName = $this->internalModelsRepositoryGetModelClassName();
            $this->internalModelsRepositoryModelObjectCache = new $modelClassName();
        }
        return clone ($this->internalModelsRepositoryModelObjectCache);
    }
}
