<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 * @property ?string $id
 * @property ?string $name
 */
class SampleModel1 extends \BearFramework\Models\Model
{

    public function __construct()
    {
        $this
            ->defineProperty('id', [
                'type' => '?string'
            ])
            ->defineProperty('name', [
                'type' => '?string'
            ]);
    }
}
