<?php

namespace TypiCMS\Modules\Files\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('see-all-files')) {
            return;
        }
        $view->sidebar->group(__('Media'), function (SidebarGroup $group) {
            $group->id = 'media';
            $group->weight = 40;
            $group->addItem(__('Files'), function (SidebarItem $item) {
                $item->id = 'files';
                $item->icon = config('typicms.files.sidebar.icon', 'icon fa fa-fw fa-file-photo-o');
                $item->weight = config('typicms.files.sidebar.weight');
                $item->route('admin::index-files');
                $item->append('admin::create-file');
            });
        });
    }
}
