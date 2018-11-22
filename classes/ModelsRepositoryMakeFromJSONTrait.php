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
trait ModelsRepositoryMakeFromJSONTrait
{

    /**
     * 
     * @param string $data
     * @return object
     */
    public function makeFromJSON(string $data)
    {
        return $this->internalModelsRepositoryMakeFromJSON($data);
    }

}
