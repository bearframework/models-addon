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
trait ModelsRepositoryFromArrayTrait
{

    use \IvoPetkov\DataObjectFromArrayTrait;

    /**
     * 
     * @param array $data
     */
    public function __fromArray(array $data): void
    {
        foreach ($data as $item) {
            $this->internalModelsRepositorySet($this->internalModelsRepositoryMakeFromArray($item));
        }
    }
}
