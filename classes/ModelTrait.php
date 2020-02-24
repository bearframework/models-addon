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
 * @codeCoverageIgnore
 */
trait ModelTrait
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;
    use \IvoPetkov\DataObjectFromArrayTrait {
        fromArray as private dataObjectFromArray;
    }
    use \IvoPetkov\DataObjectFromJSONTrait {
        fromJSON as private dataObjectFromJSON;
    }

    static private  $internalModelsModelCache = [];

    static private function internalModelsGetModel(string $class)
    {
        if (!isset(self::$internalModelsModelCache[$class])) {
            $model = new $class();
            self::$internalModelsModelCache[$class] = [$model, method_exists($model, '__modelWakeup')];
        }
        return [clone (self::$internalModelsModelCache[$class][0]), self::$internalModelsModelCache[$class][1]];
    }

    static public function fromArray(array $data)
    {
        list($model, $hasWakeup) = self::internalModelsGetModel(get_called_class());
        if ($hasWakeup) {
            $data = $model->__modelWakeup($data);
        }
        $model->__fromArray($data);
        return $model;
    }

    static public function fromJSON(string $data)
    {
        list($model, $hasWakeup) = self::internalModelsGetModel(get_called_class());
        if ($hasWakeup) {
            $data = json_decode($data, true);
            $data = $model->__modelWakeup($data);
            $data = json_encode($data);
        }
        $model->__fromJSON($data);
        return $model;
    }
}
