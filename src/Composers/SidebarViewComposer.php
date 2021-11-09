<?php

namespace TypiCMS\Modules\Files\Composers;

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('read files')) {
            return;
        }
        $view->sidebar->group(__('Media'), function (SidebarGroup $group) {
            $group->id = 'media';
            $group->weight = 40;
            $group->addItem(__('Files'), function (SidebarItem $item) {
                $item->id = 'files';
                $item->icon = config('typicms.files.sidebar.icon');
                $item->weight = config('typicms.files.sidebar.weight');
                $item->route('admin::index-files');
            });
        });
    }
}
