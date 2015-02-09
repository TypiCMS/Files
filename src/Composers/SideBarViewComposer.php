<?php
namespace TypiCMS\Modules\Files\Composers;

use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['media']->put('files', [
            'weight' => config('typicms.files.sidebar.weight'),
            'request' => $view->prefix . '/files*',
            'route' => 'admin.files.index',
            'icon-class' => 'icon fa fa-fw fa-file-photo-o',
            'title' => 'Files',
        ]);
    }
}
