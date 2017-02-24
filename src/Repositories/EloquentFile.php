<?php

namespace TypiCMS\Modules\Files\Repositories;

use stdClass;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Files\Models\File;

class EloquentFile extends EloquentRepository
{
    protected $repositoryId = 'files';

    protected $model = File::class;

    /**
     * Delete multiple models.
     *
     * @return bool
     */
    public function deleteMultiple($ids)
    {
        $deleted = $this->createModel()->destroy($ids);
        $this->forgetCache();

        return $deleted;
    }
}
