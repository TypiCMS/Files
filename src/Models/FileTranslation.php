<?php

namespace TypiCMS\Modules\Files\Models;

use TypiCMS\Modules\Core\Models\BaseTranslation;

class FileTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Files\Models\File', 'file_id');
    }
}
