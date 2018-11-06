<?php

namespace TypiCMS\Modules\Files\Presenters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get the path of the image or the path to the default image.
     *
     * @return string path
     */
    protected function getImageUrlOrDefault()
    {
        $imagePath = $this->entity->path;

        if (!Storage::exists($imagePath)) {
            $imagePath = $this->imgNotFound();
        }

        return Storage::url($imagePath);
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
