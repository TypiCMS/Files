<?php
namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Input;
use TypiCMS\Http\Controllers\AdminSimpleController;
use TypiCMS\Modules\Files\Repositories\FileInterface;
use TypiCMS\Modules\Files\Services\Form\FileForm;
use View;

class AdminController extends AdminSimpleController
{

    public function __construct(FileInterface $file, FileForm $fileform)
    {
        parent::__construct($file, $fileform);
        $this->title['parent'] = trans_choice('files::global.files', 2);
    }

    /**
     * List files
     * @return response views
     */
    public function index()
    {
        $page       = Input::get('page');
        $type       = Input::get('type');
        $gallery_id = Input::get('gallery_id');
        $view       = Input::get('view');
        if ($view != 'filepicker') {
            return parent::index();
        }

        $perPage = config('typicms.files.per_page');

        $data = $this->repository->byPageFrom($page, $perPage, $gallery_id, ['translations'], true, $type);

        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('files::admin.' . $view)
            ->with(compact('models'));
    }
}
