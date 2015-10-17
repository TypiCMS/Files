<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Input;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
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
     * @return response views
     */
    public function index()
    {
        $page = Input::get('page');
        $type = Input::get('type');
        $gallery_id = Input::get('gallery_id');
        $view = Input::get('view');
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
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     *
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());

        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param FormRequest $request
     *
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $model);
    }
}
