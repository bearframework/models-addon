<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

use BearFramework\App;

/**
 * 
 */
trait ModelsRepositoryTrait
{

    /**
     *
     * @internal
     * @var ?\BearFramework\Models\IDataDriver 
     */
    private $internalModelsRepositoryDataDriver = null;

    /**
     *
     * @internal
     * @var ?array 
     */
    private $internalModelsRepositoryModel = null;

    /**
     * 
     * @param string $class
     * @param string $idProperty
     * @return void
     * @throws \Exception
     */
    protected function setModel(string $class, string $idProperty = null): void
    {
        if ($this->internalModelsRepositoryModel !== null) {
            throw new \Exception('A model is already specified for this repository!');
        }
        $this->internalModelsRepositoryModel = [0, $class, $idProperty];
    }

    /**
     * 
     * @param \BearFramework\Models\IDataDriver $driver
     * @return void
     * @throws \Exception
     */
    protected function setDataDriver(\BearFramework\Models\IDataDriver $driver): void
    {
        if ($this->internalModelsRepositoryDataDriver !== null) {
            throw new \Exception('A data driver is already specified for this repository!');
        }
        $this->internalModelsRepositoryDataDriver = $driver;
    }

    /**
     * 
     * @param string $dataKeyPrefix
     * @param callable|null $dataKeyCallback
     * @return void
     * @throws \Exception
     */
    protected function useAppDataDriver(string $dataKeyPrefix, callable $dataKeyCallback = null): void
    {
        $this->setDataDriver(new \BearFramework\Models\AppDataDriver($dataKeyPrefix, $dataKeyCallback));
    }

    /**
     * 
     * @return void
     * @throws \Exception
     */
    protected function useMemoryDataDriver(): void
    {
        $this->setDataDriver(new \BearFramework\Models\MemoryDataDriver());
    }

    /**
     * 
     * @internal
     * @return string
     * @throws \Exception
     */
    private function internalModelsRepositoryGetModelClassName(): string
    {
        if ($this->internalModelsRepositoryModel !== null) {
            $class = $this->internalModelsRepositoryModel[1];
            if ($this->internalModelsRepositoryModel[0] === 0) {
                if (!class_exists($class)) {
                    throw new \Exception('Cannot find class named ' . $class . '!');
                }
                $this->internalModelsRepositoryModel[0] = 1;
            }
            return $class;
        }
        throw new \Exception('No model specified! Use setModel() in the repository constructor to specify one.');
    }

    /**
     * 
     * @internal
     * @return string
     * @throws \Exception
     */
    private function internalModelsRepositoryGetModelIDProperty(): string
    {
        if ($this->internalModelsRepositoryModel !== null) {
            $idProperty = $this->internalModelsRepositoryModel[2];
            if (strlen($idProperty) === 0) {
                throw new \Exception('No idProperty specified form model ' . $this->internalModelsRepositoryModel[1] . '!');
            }
            return $idProperty;
        }
        throw new \Exception('No model specified! Use setModel() in the repository constructor to specify one.');
    }

    /**
     * 
     * @internal
     * @return \BearFramework\Models\IDataDriver
     * @throws \Exception
     */
    private function internalModelsRepositoryGetDataDriver(): \BearFramework\Models\IDataDriver
    {
        if ($this->internalModelsRepositoryDataDriver !== null) {
            return $this->internalModelsRepositoryDataDriver;
        }
        throw new \Exception('No data driver specified! Use useAppDataDriver() or useMemoryDataDriver() in the repository constructor to specify one.');
    }

    /**
     * 
     * @param array $data
     * @return object
     */
    private function internalModelsRepositoryMakeFromArray(array $data)
    {
        return call_user_func([$this->internalModelsRepositoryGetModelClassName(), 'fromArray'], $data);
    }

    /**
     * 
     * @param string $data
     * @return object
     */
    private function internalModelsRepositoryMakeFromJSON(string $data)
    {
        return call_user_func([$this->internalModelsRepositoryGetModelClassName(), 'fromJSON'], $data);
    }

    /**
     * 
     * @param object $model
     * @return void
     * @throws \InvalidArgumentException
     */
    private function internalModelsRepositorySet($model): void
    {
        $modelClassName = $this->internalModelsRepositoryGetModelClassName();
        if (!is_a($model, $modelClassName)) {
            throw new \InvalidArgumentException('The model provided is not of class ' . $modelClassName . '!');
        }
        $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
        if (!isset($model->$modelIDProperty)) {
            throw new \InvalidArgumentException('The value for the model ID property (' . $modelIDProperty . ') is not set!');
        }
        $id = $model->$modelIDProperty;
        if (!is_string($id)) {
            throw new \InvalidArgumentException('The ID value of the model is not a string!');
        }
        if (strlen($id) === 0) {
            throw new \InvalidArgumentException('The ID value of the model is empty!');
        }
        // $app = App::get();
        // $lockKey = 'bearframework-models-modify-' . $modelClassName;
        // $app->locks->acquire($lockKey);
        // try {
        $modelData = $model->toJSON(); // toJSON is used because toArray does not encode the binary data.
        if (method_exists($model, '__modelSleep')) {
            $modelData = json_encode($model->__modelSleep(json_decode($modelData, true)));
        }
        $this->internalModelsRepositoryGetDataDriver()->set($id, $modelData);
        //$app->locks->release($lockKey);
        // } catch (\Exception $e) {
        //     $app->locks->release($lockKey);
        //     throw $e;
        // }
    }

    /**
     * 
     * @param object $model
     * @return string
     * @throws \InvalidArgumentException
     */
    // private function internalModelsRepositoryAdd($model): string
    // {
    //     $modelClassName = $this->internalModelsRepositoryGetModelClassName();
    //     if (!is_a($model, $modelClassName)) {
    //         throw new \InvalidArgumentException('The model provided is not of class ' . $modelClassName . '!');
    //     }
    //     $modelIDProperty = $this->internalModelsRepositoryGetModelIDProperty();
    //     if (strlen($model->$modelIDProperty) > 0) {
    //         throw new \InvalidArgumentException('The value for the model ID property (' . $modelIDProperty . ') must be null!');
    //     }
    //     $app = App::get();
    //     $lockKey = 'bearframework-models-modify-' . $modelClassName;
    //     $app->locks->acquire($lockKey);
    //     try {
    //         $id = null;
    //         for ($i = 0; $i < 1000; $i++) {
    //             $generatedID = md5(uniqid());
    //             if (!$this->internalModelsRepositoryGetDataDriver()->exists($generatedID)) {
    //                 $id = $generatedID;
    //                 break;
    //             }
    //         }
    //         if ($id === null) {
    //             throw new \Error('Cannot generate model id!');
    //         }
    //         $model->$modelIDProperty = $id;
    //         $modelData = $model->toJSON(); // toJSON is used because toArray does not encode the binary data.
    //         if (method_exists($model, '__modelSleep')) {
    //             $modelData = json_encode($model->__modelSleep(json_decode($modelData, true)));
    //         }
    //         $this->internalModelsRepositoryGetDataDriver()->set($id, $modelData);
    //         $app->locks->release($lockKey);
    //     } catch (\Exception $e) {
    //         $app->locks->release($lockKey);
    //         throw $e;
    //     }
    //     return $id;
    // }

    /**
     * 
     * @return \BearFramework\Models\ModelsList
     */
    private function internalModelsRepositoryGetList(): \BearFramework\Models\ModelsList
    {
        return new \BearFramework\Models\ModelsList(function () {
            $modelsJSON = $this->internalModelsRepositoryGetDataDriver()->getAll();
            $class = $this->internalModelsRepositoryGetModelClassName();
            $result = [];
            foreach ($modelsJSON as $modelJSON) {
                $result[] = call_user_func([$class, 'fromJSON'], $modelJSON);
            }
            return $result;
        });
    }
}
