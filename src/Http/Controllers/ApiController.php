<?php
namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Support\Facades\Input;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Repositories\FileInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get models
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        $gallery_id = Input::get('gallery_id');
        $type = Input::get('type');
        $page = Input::get('page');
        $perPage = config('typicms.files.per_page');
        if ($gallery_id = Input::get('gallery_id', 0)) {
            $models = $this->repository->allBy('gallery_id', $gallery_id, [], true);
        } else if (Input::get('view') == 'filepicker') {
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
     * @param  FormRequest $request
     * @return Model|false
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create(Input::all());
        $error = $model ? false : true ;
        return response()->json([
            'error' => $error,
            'model' => $model,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return boolean
     */
    public function update($model, FormRequest $request)
    {
        $error = $this->repository->update($request->all()) ? false : true ;
        return response()->json([
            'error' => $error,
        ], 200);
    }
}
