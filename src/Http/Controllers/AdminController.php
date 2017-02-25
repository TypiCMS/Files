<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Database\QueryException;
use stdClass;
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
        $folderId = request('folder_id');
        $repository = $this->repository;
        $repository->where('folder_id', $folderId);
        $models = $repository->findAll();
        if (request()->wantsJson()) {
            return response()->json($models, 200);
        }

        $folder = $repository->find($folderId);
        $path = collect();
        while ($folder) {
            $path[] = $folder;
            $folder = $folder->folder;
        }

        $firstItem = new stdClass;
        $firstItem->name = 'Fichiers';
        $firstItem->id = null;

        $path = $path
            ->push($firstItem)
            ->reverse()
            ->transform(function($folder, $index) {
                if ($index == 0) {
                    return $folder->name;
                }
                return '<a href="?folder_id='.$folder->id.'">'.$folder->name.'</a>';
            })->toArray();

        app('JavaScript')->put('models', $models);

        return view('files::admin.index')
            ->with(compact('path'));
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

    /**
     * Delete multiple resources.
     *
     * @param $ids
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMultiple($ids)
    {
        try {
            $number = $this->repository->createModel()->destroy(explode(',', $ids));
        } catch (QueryException $e) {
            $message = __('A non-empty folder cannot be deleted.');
            $number = 0;
        }
        $this->repository->forgetCache();

        return response()->json(compact('number', 'message'));
    }
}
