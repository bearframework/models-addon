<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class ModelsTest extends BearFramework\AddonTests\PHPUnitTestCase
{

    /**
     * 
     */
    public function testBasics()
    {
        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository = new SampleRepository1($dataDriver);

            $model = $repository->make();
            $model->id = '1';
            $model->name = 'John';
            $repository->set($model);
            $modelID = $model->id;

            $this->assertTrue($repository->getList()->count() === 1, $assertMessage);
            $this->assertTrue($repository->get($modelID)->name === 'John', $assertMessage);
            $this->assertTrue($repository->exists($modelID) === true, $assertMessage);
            $repository->delete($modelID);
            $this->assertTrue($repository->getList()->count() === 0, $assertMessage);
            $this->assertTrue($repository->get($modelID) === null, $assertMessage);
            $this->assertTrue($repository->exists($modelID) === false, $assertMessage);

            $model = $repository->make();
            $model->id = '2';
            $model->name = 'Mark';
            $repository->set($model);

            $model = $repository->make();
            $model->id = '3';
            $model->name = 'Matt';
            $repository->set($model);

            $this->assertTrue($repository->getList()->count() === 2, $assertMessage);
            $repository->deleteAll();
            $this->assertTrue($repository->getList()->count() === 0, $assertMessage);
        }
    }

    /**
     * 
     */
    public function testSerialization1()
    {
        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository1 = new SampleRepository1($dataDriver);

            $model = $repository1->make();
            $model->id = 'id1';
            $model->name = 'John';
            $repository1->set($model);

            $model = $repository1->make();
            $model->id = 'id2';
            $model->name = 'Mark';
            $repository1->set($model);

            $expectedArray1 = [
                [
                    'id' => 'id1',
                    'name' => 'John'
                ],
                [
                    'id' => 'id2',
                    'name' => 'Mark'
                ]
            ];
            $expectedArray2 = [
                [
                    'id' => 'id2',
                    'name' => 'Mark'
                ],
                [
                    'id' => 'id1',
                    'name' => 'John'
                ]
            ];
            $expectedJSON1 = '[{"id":"id1","name":"John"},{"id":"id2","name":"Mark"}]';
            $expectedJSON2 = '[{"id":"id2","name":"Mark"},{"id":"id1","name":"John"}]';

            $repository1Array = $repository1->toArray();
            $repository1JSON = $repository1->toJSON();
            $this->assertTrue($repository1Array === $expectedArray1 || $repository1Array === $expectedArray2, $assertMessage);
            $this->assertTrue($repository1JSON === $expectedJSON1 || $repository1JSON === $expectedJSON2, $assertMessage);

            $repository2 = SampleRepository1::fromJSON($expectedJSON1);
            $repository2Array = $repository2->toArray();
            $repository2JSON = $repository2->toJSON();
            $this->assertTrue($repository2Array === $expectedArray1 || $repository2Array === $expectedArray2, $assertMessage);
            $this->assertTrue($repository2JSON === $expectedJSON1 || $repository2JSON === $expectedJSON2, $assertMessage);

            $repository3 = SampleRepository1::fromArray($expectedArray1);
            $repository3Array = $repository3->toArray();
            $repository3JSON = $repository3->toJSON();
            $this->assertTrue($repository3Array === $expectedArray1 || $repository3Array === $expectedArray2, $assertMessage);
            $this->assertTrue($repository3JSON === $expectedJSON1 || $repository3JSON === $expectedJSON2, $assertMessage);
        }
    }

    /**
     * 
     */
    public function testSerialization2()
    {
        $dataDrivers = ['memory', 'data'];
        foreach ($dataDrivers as $dataDriver) {
            $assertMessage = 'Data driver: ' . $dataDriver;

            $repository = new SampleRepository1($dataDriver);

            $model = $repository->make();
            $model->id = 'id1';
            $model->name = 'John';

            $expectedArray = [
                'id' => 'id1',
                'name' => 'John'
            ];
            $expectedJSON = '{"id":"id1","name":"John"}';
            $this->assertTrue($model->toArray() === $expectedArray, $assertMessage);
            $this->assertTrue($model->toJSON() === $expectedJSON, $assertMessage);

            $model1 = $repository->makeFromJSON($expectedJSON);
            $this->assertTrue($model1 instanceof SampleModel1, $assertMessage);
            $this->assertTrue($model1->id === 'id1', $assertMessage);
            $this->assertTrue($model1->name === 'John', $assertMessage);

            $model2 = $repository->makeFromArray($expectedArray);
            $this->assertTrue($model2 instanceof SampleModel1, $assertMessage);
            $this->assertTrue($model2->id === 'id1', $assertMessage);
            $this->assertTrue($model2->name === 'John', $assertMessage);
        }
    }

    /**
     * 
     */
    public function testNoModelSpecified()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->useMemoryDataDriver();
            }
        };

        $this->expectException(\Exception::class);
        $repository->make();
    }

    /**
     * 
     */
    public function testInvalidModelClass()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel('InvalidModel');
            }
        };

        $this->expectException(\Exception::class);
        $repository->make();
    }

    /**
     * 
     */
    public function testNoDataDrivierSpecified()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel1::class);
            }
        };

        $model = $repository->make();
        $model->id = '1';
        $model->name = 'John';
        $this->expectException(\Exception::class);
        $repository->set($model);
    }

    /**
     * 
     */
    public function testOverwriteModel()
    {
        $this->expectException(\Exception::class);
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel1::class);
                $this->setModel(SampleModel1::class);
            }
        };
    }

    /**
     * 
     */
    public function testOverwriteDataDriver()
    {
        $this->expectException(\Exception::class);
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->useMemoryDataDriver();
                $this->useMemoryDataDriver();
            }
        };
    }

    /**
     * 
     */
    public function testEmptyModelID()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $model = new SampleModel1();
        $model->id = '';
        $model->name = 'John';
        $this->expectException(\InvalidArgumentException::class);
        $repository->set($model);
    }

    /**
     * 
     */
    public function testCreateNotEmptyModelID()
    {
        $repository = new SampleRepository3('memory');
        $model = new SampleModel1();
        $model->id = 'test';
        $model->name = 'John';
        $this->expectException(\InvalidArgumentException::class);
        $repository->add($model);
    }

    /**
     * 
     */
    public function testCreate()
    {
        $repository = new SampleRepository3('memory');
        $model1 = new SampleModel1();
        $model1->name = 'John';
        $model1ID = $repository->add($model1);
        $this->assertTrue(strlen($model1ID) === 15); // default generator length
        $this->assertTrue($repository->exists($model1ID));

        $model2ID = 'id1';
        $this->assertFalse($repository->exists($model2ID));
        $model2 = new SampleModel1();
        $model2->id = $model2ID;
        $model2->name = 'John';
        $repository->set($model2);

        $this->assertTrue($repository->exists($model1ID));
        $this->assertTrue($repository->exists($model2ID));
    }

    /**
     * 
     */
    public function testCreateWithIDGenerator()
    {
        $repository = new SampleRepository4('memory');
        $model1 = new SampleModel1();
        $model1->name = 'John';
        $model1ID = $repository->add($model1);
        $this->assertTrue(strpos($model1ID, 'custom-generator-') === 0);
        $this->assertTrue($repository->exists($model1ID));
    }

    /**
     * 
     */
    public function testInvalidModelID()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel2::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $model = new SampleModel2();
        $model->id = [1];
        $model->name = 'John';
        $this->expectException(\InvalidArgumentException::class);
        $repository->set($model);
    }

    /**
     * 
     */
    public function testMissingModelID()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel2::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $model = new SampleModel2();
        unset($model->id);
        $model->name = 'John';
        $this->expectException(\InvalidArgumentException::class);
        $repository->set($model);
    }

    /**
     * 
     */
    public function testInvalidModelSet()
    {
        $repository = new class extends \BearFramework\Models\ModelsRepository
        {

            public function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $model = new SampleModel2();
        $model->id = 'id1';
        $model->name = 'John';
        $this->expectException(\InvalidArgumentException::class);
        $repository->set($model);
    }

    /**
     * 
     */
    public function testTraitCombinations1()
    {
        $modelsArray = [];
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';
        $modelsArray[] = $model->toArray();
        $model = new SampleModel1();
        $model->id = 'id2';
        $model->name = 'Mark';
        $modelsArray[] = $model->toArray();

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryFromArrayTrait;
            use \BearFramework\Models\ModelsRepositoryToArrayTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };

        $this->assertEquals($modelsArray, $repository::fromArray($modelsArray)->toArray());
    }

    /**
     * 
     */
    public function testTraitCombinations2()
    {
        $modelsArray = [];
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';
        $modelsArray[] = $model->toArray();
        $model = new SampleModel1();
        $model->id = 'id2';
        $model->name = 'Mark';
        $modelsArray[] = $model->toArray();
        $modelsJSON = json_encode($modelsArray);

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryFromJSONTrait;
            use \BearFramework\Models\ModelsRepositoryToJSONTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };

        $this->assertEquals($modelsJSON, $repository::fromJSON($modelsJSON)->toJSON());
    }

    /**
     * 
     */
    public function testTraitCombinations3()
    {
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryMakeFromArrayTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $newModel = $repository->makeFromArray($model->toArray());

        $this->assertEquals('SampleModel1', get_class($newModel));
        $this->assertEquals('id1', $newModel->id);
        $this->assertEquals('John', $newModel->name);
    }

    /**
     * 
     */
    public function testTraitCombinations4()
    {
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryMakeFromJSONTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $newModel = $repository->makeFromJSON(json_encode($model->toArray()));

        $this->assertEquals('SampleModel1', get_class($newModel));
        $this->assertEquals('id1', $newModel->id);
        $this->assertEquals('John', $newModel->name);
    }

    /**
     * 
     */
    public function testTraitCombinations5()
    {
        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryMakeTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $model = $repository->make();

        $this->assertEquals('SampleModel1', get_class($model));
        $this->assertEquals(null, $model->id);
        $this->assertEquals(null, $model->name);
    }

    /**
     * 
     */
    public function testTraitCombinations6()
    {
        $modelsArray = [];
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';
        $modelsArray[] = $model->toArray();
        $model = new SampleModel1();
        $model->id = 'id2';
        $model->name = 'Mark';
        $modelsArray[] = $model->toArray();

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryFromArrayTrait;
            use \BearFramework\Models\ModelsRepositoryToArrayTrait;
            use \BearFramework\Models\ModelsRepositoryModifyTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $newRepository = $repository::fromArray($modelsArray);
        $model = new SampleModel1();
        $model->id = 'id3';
        $model->name = 'Matt';
        $newRepository->set($model);
        $this->assertEquals(array_merge($modelsArray, [['id' => 'id3', 'name' => 'Matt']]), $newRepository->toArray());
        $newRepository->delete('id3');
        $this->assertEquals($modelsArray, $newRepository->toArray());
        $newRepository->deleteAll();
        $this->assertEquals([], $newRepository->toArray());
    }

    /**
     * 
     */
    public function testTraitCombinations7()
    {
        $modelsArray = [];
        $model = new SampleModel1();
        $model->id = 'id1';
        $model->name = 'John';
        $modelsArray[] = $model->toArray();
        $model = new SampleModel1();
        $model->id = 'id2';
        $model->name = 'Mark';
        $modelsArray[] = $model->toArray();

        $repository = new class
        {

            use \BearFramework\Models\ModelsRepositoryTrait;
            use \BearFramework\Models\ModelsRepositoryFromArrayTrait;
            use \BearFramework\Models\ModelsRepositoryToArrayTrait;
            use \BearFramework\Models\ModelsRepositoryRequestTrait;

            function __construct()
            {
                $this->setModel(SampleModel1::class, 'id');
                $this->useMemoryDataDriver();
            }
        };
        $newRepository = $repository::fromArray($modelsArray);
        $this->assertEquals($modelsArray[0], $newRepository->get('id1')->toArray());
        $this->assertEquals(true, $newRepository->exists('id1'));
        $this->assertEquals(null, $newRepository->get('id3'));
        $this->assertEquals(false, $newRepository->exists('id3'));
        $this->assertEquals($modelsArray, $newRepository->getList()->toArray());
    }
}
