<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App;

$app = App::get();
$context = $app->context->get(__FILE__);

$context->classes
        ->add('BearFramework\Models\AppDataDriver', 'classes/AppDataDriver.php')
        ->add('BearFramework\Models\IDataDriver', 'classes/IDataDriver.php')
        ->add('BearFramework\Models\MemoryDataDriver', 'classes/MemoryDataDriver.php')
        ->add('BearFramework\Models\Model', 'classes/Model.php')
        ->add('BearFramework\Models\ModelsList', 'classes/ModelsList.php')
        ->add('BearFramework\Models\ModelsRepository', 'classes/ModelsRepository.php');
