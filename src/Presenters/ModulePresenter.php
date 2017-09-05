<?php

namespace TypiCMS\Modules\Files\Presenters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get the path of files linked to this model.
     *
     * @param Model  $model
     * @param string $field file’s field name in model
     *
     * @return string path
     */
    protected function getPath(Model $model = null, $field = null)
    {
        if (!$model || !$field) {
            return;
        }
        if (!Storage::has($model->path)) {
            return $this->imgNotFound();
        }

        return str_replace('public/', '/', $model->path);
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function title()
    {
        return $this->entity->name;
    }

    /**
     * Format file size.
     *
     * @return string
     */
    public function filesize($precision = 0)
    {
        $base = log($this->entity->filesize, 1024);
        $suffixes = ['', 'k', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)];
    }
}
