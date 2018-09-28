<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Http\Request;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\EloquentFile;
use stdClass;

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
        return view('files::admin.index');
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
        $data = $request->all();
        $model = $this->repository->create($data);

        if (request()->wantsJson()) {
            return response()->json([
                'error' => $model ? false : true,
                'model' => $model->load('children'),
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

    protected function moveFiles($ids, Request $request)
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        $number = 0;
        foreach (explode(',', $ids) as $id) {
            $model = $this->repository->find($id);
            foreach ($data as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
            $number += 1;
        }

        $this->repository->forgetCache();

        return response()->json(compact('number'));
    }
}
