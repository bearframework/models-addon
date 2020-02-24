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
trait ModelsRepositoryToJSONTrait
{

    /**
     * 
     * @return string
     */
    public function toJSON(): string
    {
        return $this->internalModelsRepositoryGetList()->toJSON();
    }
}
