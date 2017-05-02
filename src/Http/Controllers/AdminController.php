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
        $view = request('view', 'index');

        $data = [
            'models' => $this->repository->where('folder_id', $folderId)->findAll(),
            'path' => $this->getpath($folderId),
        ];

        if (request()->wantsJson()) {
            return response()->json($data, 200);
        }

        return view('files::admin.'.$view);
    }

    /**
     * Get folders path.
     *
     * @return array
     */
    private function getPath($folderId)
    {
        $folder = $this->repository->find($folderId);
        $path = [];
        while ($folder) {
            $path[] = $folder;
            $folder = $folder->folder;
        }

        $firstItem = new stdClass;
        $firstItem->name = 'Fichiers';
        $firstItem->type = 'f';
        $firstItem->id = '';

        $path[] = $firstItem;
        $path = array_reverse($path);

        return $path;
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->createModel();
        app('JavaScript')->put('model', $model);

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
        app('JavaScript')->put('model', $file);

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
        $data = $request->all();
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
        $data = $request->all();
        $this->repository->update($request->id, $data);

        return $this->redirect($request, $file);
    }

    /**
     * Sort files.
     */
    public function sort()
    {
        foreach (request()->all() as $position => $item) {
            app('db')->table('model_has_files')->where('file_id', $item['id'])->update(['position' => $position + 1]);
        }
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
