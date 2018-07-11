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

class SampleRepository1 extends \BearFramework\Models\ModelsRepository
{

    public function __construct(string $dataDriver = 'memory')
    {
        $this->setModel(SampleModel1::class);
        if ($dataDriver === 'memory') {
            $this->useMemoryDataDriver();
        } elseif (substr($dataDriver, 0, 4) === 'data') {
            $this->useAppDataDriver(md5($dataDriver));
        }
    }

}
