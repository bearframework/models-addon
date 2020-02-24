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
trait ModelsRepositoryFromJSONTrait
{

    use \IvoPetkov\DataObjectFromJSONTrait;

    /**
     * 
     * @param string $data
     */
    public function __fromJSON(string $data): void
    {
        $data = json_decode($data, true);
        foreach ($data as $item) {
            $this->internalModelsRepositorySet($this->internalModelsRepositoryMakeFromJSON(json_encode($item)));
        }
    }
}
