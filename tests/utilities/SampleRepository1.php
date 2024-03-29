<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleRepository1 extends \BearFramework\Models\ModelsRepository
{

    public function __construct(string $dataDriver = 'memory')
    {
        $this->setModel(SampleModel1::class, 'id');
        if ($dataDriver === 'memory') {
            $this->useMemoryDataDriver();
        } elseif ($dataDriver === 'data') {
            $this->useAppDataDriver('prefix1/');
        }
    }

}
