<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Support\Facades\Request;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\EloquentFile as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * List resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $gallery_id = Request::input('gallery_id');
        $type = Request::input('type');
        $page = Request::input('page');
        $perPage = config('typicms.files.per_page');
        if ($gallery_id = Request::input('gallery_id', 0)) {
            $models = $this->repository->allBy('gallery_id', $gallery_id, [], true);
        } elseif (Request::input('view') == 'filepicker') {
            $models = $this->repository->byPageFrom($page, $perPage, $gallery_id, [], true, $type);
            $models = $models->items;
        } else {
            $models = $this->repository->all([], true);
        }

        return response()->json($models, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Files\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        $error = $model ? false : true;

        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Files\Models\File               $file
     * @param \TypiCMS\Modules\Files\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(File $file, FormRequest $request)
    {
        $error = $this->repository->update($request->all()) ? false : true;

        return response()->json([
            'error' => $error,
        ], 200);
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
