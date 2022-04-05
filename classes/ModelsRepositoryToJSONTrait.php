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
     * Returns the repository converted as JSON.
     * 
     * @param array $options Available options: ignoreReadonlyProperties, properties=>[]
     * @return string The repository converted as JSON.
     */
    public function toJSON(array $options = []): string
    {
        return $this->internalModelsRepositoryGetList()->toJSON($options);
    }
}
