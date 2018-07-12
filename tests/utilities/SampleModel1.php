<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleModel1 extends \BearFramework\Models\Model
{

    public function __construct()
    {
        parent::__construct();
        $this
                ->defineProperty('name', [
                    'type' => '?string'
        ]);
    }

}
