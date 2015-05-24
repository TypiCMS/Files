<?php
namespace TypiCMS\Modules\Files\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use TypiCMS\Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.media'), function (SidebarGroup $group) {
            $group->addItem(trans('files::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.files.sidebar.icon', 'icon fa fa-fw fa-file-photo-o');
                $item->weight = config('typicms.files.sidebar.weight');
                $item->route('admin.files.index');
                $item->append('admin.files.create');
                $item->authorize(
                    $this->user->hasAccess('files.index')
                );
            });
        });
    }
}
