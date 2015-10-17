<?php

namespace TypiCMS\Modules\Files\Presenters;

use Illuminate\Database\Eloquent\Model;
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

        return '/'.$model->path.'/'.$model->$field;
    }

    /**
     * Return an icon and file name.
     *
     * @param int    $size  icon size
     * @param string $field field name
     *
     * @return string HTML code
     */
    public function icon($size = 1, $field = 'document')
    {
        $file = $this->getPath($this->entity, $field);
        $html = '<div class="doc">';
        $html .= '<span class="text-center fa fa-file-o fa-'.$size.'x"></span>';
        $html .= ' <a href="'.$file.'">';
        $html .= $this->entity->$field;
        $html .= '</a>';
        if (!is_file(public_path().$file)) {
            $html .= ' <span class="text-danger">('.trans('global.Not found').')</span>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function title()
    {
        return $this->entity->file;
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
