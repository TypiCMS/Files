<?php

namespace TypiCMS\Modules\Files\Traits;

use TypiCMS\Modules\Files\Models\File;

trait HasFiles
{
    public function images()
    {
        return $this->files()->where('type', 'i');
    }

    public function documents()
    {
        return $this->files()->where('type', 'd');
    }

    public function videos()
    {
        return $this->files()->where('type', 'v');
    }

    public function audios()
    {
        return $this->files()->where('type', 'a');
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files', 'model_id', 'file_id')
            ->orderBy('model_has_files.position');
    }
}
