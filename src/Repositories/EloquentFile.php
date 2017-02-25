<?php

namespace TypiCMS\Modules\Files\Repositories;

use stdClass;
use TypiCMS\Modules\Core\Repositories\EloquentRepository;
use TypiCMS\Modules\Files\Models\File;

class EloquentFile extends EloquentRepository
{
    protected $repositoryId = 'files';

    protected $model = File::class;
}
