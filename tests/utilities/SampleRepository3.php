<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleRepository3 extends \BearFramework\Models\ModelsRepository
{

    use \BearFramework\Models\ModelsRepositoryCreateTrait;

    public function __construct(string $dataDriver = 'memory')
    {
        $this->setModel(SampleModel1::class, 'id');
        if ($dataDriver === 'memory') {
            $this->useMemoryDataDriver();
        } elseif ($dataDriver === 'data') {
            $this->useAppDataDriver('prefix3/');
        }
    }
}
