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
        parent::__construct();
        $this->setModel(SampleModel1::class);
        if ($dataDriver === 'memory') {
            $this->useMemoryDataDriver();
        } elseif (substr($dataDriver, 0, 4) === 'data') {
            $this->useAppDataDriver(md5($dataDriver));
        }
    }

}
