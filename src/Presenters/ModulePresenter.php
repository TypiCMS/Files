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
        if ($model === null || $field === null) {
            return;
        }

        $file = $model->path;

        if (!Storage::exists($file)) {
            $file = $this->imgNotFound();
        }

        return Storage::url($file);
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
        $suffixes = ['', __('KB'), __('MB'), __('GB'), __('TB')];

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }
}
