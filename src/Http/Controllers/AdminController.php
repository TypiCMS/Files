<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\FileInterface;

class AdminController extends BaseAdminController
{
    public function __construct(FileInterface $file)
    {
        parent::__construct($file);
    }

    /**
     * List files.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = Request::input('page');
        $type = Request::input('type');
        $gallery_id = Request::input('gallery_id');
        $view = Request::input('view');
        if ($view != 'filepicker') {
            return parent::index();
        }

        $perPage = config('typicms.files.per_page');

        $data = $this->repository->byPageFrom($page, $perPage, $gallery_id, ['translations'], true, $type);

        $models = new Paginator($data->items, $data->totalItems, $perPage, null, ['path' => Paginator::resolveCurrentPath()]);

        return view('files::admin.'.$view)
            ->with(compact('models'));
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('core::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Files\Models\File $file
     *
     * @return \Illuminate\View\View
     */
    public function edit(File $file)
    {
        return view('core::admin.edit')
            ->with(['model' => $file]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Files\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());

        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Files\Models\File               $file
     * @param \TypiCMS\Modules\Files\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(File $file, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $file);
    }
}
