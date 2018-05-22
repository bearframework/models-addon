<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) 2018 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Models;

/**
 *
 */
class Model
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;
    use \IvoPetkov\DataObjectFromArrayTrait;
    use \IvoPetkov\DataObjectFromJSONTrait;

    /**
     * 
     */
    function __construct()
    {
        $this->defineProperty('key', [
            'type' => '?string',
            'set' => function($value) {
                if ($value === null || preg_match("/^[a-z0-9]{1}[a-z0-9\.\-\_]*[a-z0-9]{1}$/", $value) === 1) {
                    return $value;
                } else {
                    throw new \Exception('');
                }
            }
        ]);
    }

}
