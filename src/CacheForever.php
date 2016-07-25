<?php

namespace Cklmercer\ModelStash;

use Illuminate\Support\Facades\Cache;

trait CacheForever
{
    /**
     * Boot the CacheForever trait.
     */
    public static function bootCacheForever()
    {
        self::created(function ($model) {
            $model->cacheInstance();
            $model->cacheAll();
        });

        self::updated(function ($model) {
            $model->forgetCache();
            $model->cacheInstance();
            $model->cacheAll();
        });

        self::deleted(function ($model) {
            $model->forgetCache();
            $model->cacheAll();
        });

        self::restored(function ($model) {
            $model->forgetCache();
            $model->cacheAll();
        });
    }

    /**
     * Cache all instances of the model forever.
     *
     * @return void
     */
    public function cacheAll()
    {
        $cacheName = $this->getCacheName();

        Cache::forget($cacheName);

        Cache::rememberForever($cacheName, function () {
            return $this->all();
        });
    }

    /**
     * Cache the model forever.
     *
     * @return void
     */
    public function cacheInstance()
    {
        Cache::rememberForever($this->getCacheName().':'.$this->getCacheKey(), function () {
            return $this;
        });
    }

    /**
     * Remove the model from the cache.
     *
     * @return void
     */
    public function forgetCache()
    {
        Cache::forget($this->getCacheName().':'.$this->getCacheKey());
    }

    /**
     * Get the model's cache key.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return isset($this->cacheKey)
            ? $this->{$this->cacheKey}
            : $this->getRouteKey();
    }

    /**
     * Get the model's cache name.
     *
     * @return string
     */
    public function getCacheName()
    {
        return isset($this->cacheName) 
            ? $this->cacheName
            : str_plural(str_slug(last(explode('\\', get_class($this)))));
    }
}