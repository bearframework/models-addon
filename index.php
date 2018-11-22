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
        ->add('BearFramework\Models\ModelTrait', 'classes/ModelTrait.php')
        ->add('BearFramework\Models\ModelsList', 'classes/ModelsList.php')
        ->add('BearFramework\Models\ModelsRepository', 'classes/ModelsRepository.php')
        ->add('BearFramework\Models\ModelsRepositoryFromArrayTrait', 'classes/ModelsRepositoryFromArrayTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryFromJSONTrait', 'classes/ModelsRepositoryFromJSONTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryMakeFromArrayTrait', 'classes/ModelsRepositoryMakeFromArrayTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryMakeFromJSONTrait', 'classes/ModelsRepositoryMakeFromJSONTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryMakeTrait', 'classes/ModelsRepositoryMakeTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryModifyTrait', 'classes/ModelsRepositoryModifyTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryRequestTrait', 'classes/ModelsRepositoryRequestTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryToArrayTrait', 'classes/ModelsRepositoryToArrayTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryToJSONTrait', 'classes/ModelsRepositoryToJSONTrait.php')
        ->add('BearFramework\Models\ModelsRepositoryTrait', 'classes/ModelsRepositoryTrait.php');
