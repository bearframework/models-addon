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
trait ModelsRepositoryMakeFromArrayTrait
{

    /**
     * 
     * @param array $data
     * @return object
     */
    public function makeFromArray(array $data)
    {
        return $this->internalModelsRepositoryMakeFromArray($data);
    }
}
