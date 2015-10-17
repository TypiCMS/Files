<?php

namespace TypiCMS\Modules\Files\Repositories;

use Illuminate\Database\Eloquent\Model;
use stdClass;
use TypiCMS\Modules\Core\Repositories\RepositoryInterface;

interface FileInterface extends RepositoryInterface
{
    /**
     * Get paginated models.
     *
     * @param int    $page       Number of models per page
     * @param int    $limit      Results per page
     * @param model  $gallery_id related model
     * @param array  $with       Eager load related models
     * @param bool   $all        get published models or all
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
    );
}
