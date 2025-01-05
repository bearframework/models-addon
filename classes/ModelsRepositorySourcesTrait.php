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
 */
trait ModelsRepositorySourcesTrait
{

    /**
     *
     * @internal
     * @var array|null
     */
    private $internalModelsRepositorySources = null;

    /**
     *
     * @internal
     * @var array|null
     */
    private $internalModelsRepositorySourcesDataCache = null;

    /**
     * 
     * @param callable $callback
     * @return self
     */
    public function addSource(callable $callback): self
    {
        if ($this->internalModelsRepositorySources === null) {
            $this->internalModelsRepositorySources = [];
        }
        $this->internalModelsRepositorySources[] = $callback;
        return $this;
    }

    /**
     * 
     * @return \BearFramework\Models\ModelsList
     */
    private function internalModelsRepositoryGetSourcesModelsList(): \BearFramework\Models\ModelsList
    {
        if ($this->internalModelsRepositorySourcesDataCache === null) {
            $this->internalModelsRepositorySourcesDataCache = [];
        }
        $cacheKey = implode('-', array_keys($this->internalModelsRepositorySources));
        if (!isset($this->internalModelsRepositorySourcesDataCache[$cacheKey])) {
            $result = [];
            foreach ($this->internalModelsRepositorySources as $callback) {
                $items = call_user_func($callback);
                foreach ($items as $item) {
                    $result[] = $item->toArray();
                }
            }
            $this->internalModelsRepositorySourcesDataCache[$cacheKey] = $result;
        }
        $class = $this->internalModelsRepositoryGetModelClassName();
        $result = [];
        foreach ($this->internalModelsRepositorySourcesDataCache[$cacheKey] as $modelAsArray) {
            $result[] = call_user_func([$class, 'fromArray'], $modelAsArray);
        }
        return new \BearFramework\Models\ModelsList($result);
    }
}
