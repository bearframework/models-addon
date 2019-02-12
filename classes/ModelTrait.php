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

    static public function fromArray(array $data)
    {
        $class = get_called_class();
        $model = new $class();
        if (method_exists($model, '__modelWakeup')) {
            $data = $model->__modelWakeup($data);
        }
        $model->__fromArray($data);
        return $model;
    }

    static public function fromJSON(string $data)
    {
        $class = get_called_class();
        $model = new $class();
        if (method_exists($model, '__modelWakeup')) {
            $data = json_decode($data, true);
            $data = $model->__modelWakeup($data);
            $data = json_encode($data);
        }
        $model->__fromJSON($data);
        return $model;
    }

}
