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
trait ModelsRepositoryToArrayTrait
{

    /**
     * Returns the repository converted as array.
     * 
     * @param array $options Available options: ignoreReadonlyProperties, properties=>[]
     * @return array The repository converted as array.
     */
    public function toArray(array $options = []): array
    {
        return $this->internalModelsRepositoryGetList()->toArray($options);
    }
}
