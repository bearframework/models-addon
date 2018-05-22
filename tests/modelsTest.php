<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class ModelsTest extends BearFrameworkAddonTestCase
{

    /**
     * 
     */
    public function testBasics()
    {
        $app = $this->getApp();

        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository = new SampleRepository1($dataDriver);
            $model = $repository->make();
            $model->name = 'John';
            $repository->set($model);
            $modelKey = $model->key;

            $this->assertTrue($repository->getList()->length === 1, $assertMessage);
            $this->assertTrue($repository->get($modelKey)->name === 'John', $assertMessage);
            $this->assertTrue($repository->exists($modelKey) === true, $assertMessage);
            $repository->delete($modelKey);
            $this->assertTrue($repository->getList()->length === 0, $assertMessage);
            $this->assertTrue($repository->get($modelKey) === null, $assertMessage);
            $this->assertTrue($repository->exists($modelKey) === false, $assertMessage);
        }
    }

    public function testContexts()
    {
        $app = $this->getApp();

        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository = new SampleRepository1($dataDriver);

            $repository1 = $repository->makeContext('context1');
            $model = $repository->make();
            $model->key = 'key1';
            $model->name = 'John';
            $repository1->set($model);

            $repository2 = $repository->makeContext('context2');
            $model = $repository->make();
            $model->key = 'key1';
            $model->name = 'Mark';
            $repository2->set($model);

            $this->assertTrue($repository1->getList()->length === 1, $assertMessage);
            $this->assertTrue($repository1->get('key1')->name === 'John', $assertMessage);
            $this->assertTrue($repository1->exists('key1') === true, $assertMessage);

            $this->assertTrue($repository2->getList()->length === 1, $assertMessage);
            $this->assertTrue($repository2->get('key1')->name === 'Mark', $assertMessage);
            $this->assertTrue($repository2->exists('key1') === true, $assertMessage);

            $repository1->deleteAll();

            $this->assertTrue($repository1->getList()->length === 0, $assertMessage);
            $this->assertTrue($repository1->get('key1') === null, $assertMessage);

            $this->assertTrue($repository2->getList()->length === 1, $assertMessage);
            $this->assertTrue($repository2->get('key1')->name === 'Mark', $assertMessage);
        }
    }

    public function testSerialization()
    {
        $app = $this->getApp();

        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository1 = new SampleRepository1($dataDriver);

            $model = $repository1->make();
            $model->key = 'key1';
            $model->name = 'John';
            $repository1->set($model);

            $model = $repository1->make();
            $model->key = 'key2';
            $model->name = 'Mark';
            $repository1->set($model);

            $expectedArray = [
                [
                    'key' => 'key1',
                    'name' => 'John'
                ],
                [
                    'key' => 'key2',
                    'name' => 'Mark'
                ]
            ];
            $expectedJSON = '[{"key":"key1","name":"John"},{"key":"key2","name":"Mark"}]';

            $this->assertTrue($repository1->toArray() === $expectedArray, $assertMessage);
            $this->assertTrue($repository1->toJSON() === $expectedJSON, $assertMessage);

            $repository2 = SampleRepository1::fromJSON($expectedJSON);
            $this->assertTrue($repository2->toArray() === $expectedArray, $assertMessage);
            $this->assertTrue($repository2->toJSON() === $expectedJSON, $assertMessage);
            
            $repository3 = SampleRepository1::fromArray($expectedArray);
            $this->assertTrue($repository3->toArray() === $expectedArray, $assertMessage);
            $this->assertTrue($repository3->toJSON() === $expectedJSON, $assertMessage);
        }
    }

}
