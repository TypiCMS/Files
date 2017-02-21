<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\EloquentFile;

class AdminController extends BaseAdminController
{
    public function __construct(EloquentFile $file)
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
        $folder_id = request('folder_id', 0);
        $repository = $this->repository;
        $repository->where('folder_id', $folder_id);

        $models = $repository->findAll();

        if (request()->wantsJson()) {
            return response()->json($models, 200);
        }

        app('JavaScript')->put('models', $models);

        return view('files::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();

        return view('files::admin.create')
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
        return view('files::admin.edit')
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
        $data = $request->except(['redirect_to_gallery']);
        $model = $this->repository->create($data);

        if (request()->wantsJson()) {
            return response()->json([
                'error' => $model ? false : true,
                'model' => $model,
            ], 200);
        }

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
        $data = $request->except(['redirect_to_gallery']);
        $this->repository->update($request->id, $data);

        return $this->redirect($request, $file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \TypiCMS\Modules\Files\Models\File $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(File $file)
    {
        $deleted = $this->repository->delete($file);

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
