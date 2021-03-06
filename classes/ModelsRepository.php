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
class ModelsRepository
{

    use \BearFramework\Models\ModelsRepositoryTrait;
    use \BearFramework\Models\ModelsRepositoryFromArrayTrait;
    use \BearFramework\Models\ModelsRepositoryFromJSONTrait;
    use \BearFramework\Models\ModelsRepositoryMakeFromArrayTrait;
    use \BearFramework\Models\ModelsRepositoryMakeFromJSONTrait;
    use \BearFramework\Models\ModelsRepositoryMakeTrait;
    use \BearFramework\Models\ModelsRepositoryModifyTrait;
    use \BearFramework\Models\ModelsRepositoryRequestTrait;
    use \BearFramework\Models\ModelsRepositoryToArrayTrait;
    use \BearFramework\Models\ModelsRepositoryToJSONTrait;
}
