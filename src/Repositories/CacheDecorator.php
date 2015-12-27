<?php

namespace TypiCMS\Modules\Files\Repositories;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements FileInterface
{
    public function __construct(FileInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all models.
     *
     * @param bool  $all  Show published or all
     * @param array $with Eager load related models
     *
     * @return Collection
     */
    public function all(array $with = [], $all = false)
    {
        $cacheKey = md5(config('app.locale').'all'.implode('.', $with).$all.implode('.', Request::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->all($with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get paginated models.
     *
     * @param int    $page       Number of models per page
     * @param int    $limit      Results per page
     * @param model  $gallery_id related model
     * @param bool   $all        get published models or all
     * @param array  $with       Eager load related models
     * @param string $type       file type : a,v,d,i,o
     *
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPageFrom(
        $page = 1,
        $limit = 10,
        $gallery_id = null,
        array $with = [],
        $all = false,
        $type = null
    ) {
        $cacheKey = md5(
            config('app.locale').
            'byPageFrom'.
            $page.
            $limit.
            $gallery_id.
            $all.
            implode('.', Request::except('page')).
            $type
        );

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPageFrom($page, $limit, $gallery_id, $with, $all, $type);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
