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
            $model->cacheForever();
            $model->cacheAll();
        });

        self::updated(function ($model) {
            $model->forgetCache();
            $model->cacheForever();
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
        $indexCacheKey = str_plural($this->getCachePrefix());

        Cache::forget($indexCacheKey);

        Cache::rememberForever($indexCacheKey, function () {
            return $this->all();
        });
    }

    /**
     * Cache the model forever.
     *
     * @return void
     */
    public function cacheForever()
    {
        Cache::rememberForever($this->getCachePrefix() . ':' . $this->getRouteKey(), function () {
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
        Cache::forget($this->getCachePrefix() . ':' . $this->getRouteKey());
    }

    /**
     * Get the model's cache prefix.
     *
     * @return string
     */
    public function getCachePrefix()
    {
        return str_slug(last(explode('\\', get_class($this))));
    }
}