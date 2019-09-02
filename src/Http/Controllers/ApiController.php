<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;
use stdClass;

class ApiController extends BaseApiController
{
    public function index(Request $request): array
    {
        $folderId = request('folder_id');

        $data = [
            'models' => File::with('children')->where('folder_id', $folderId)->get(),
            'path' => $this->getPath($folderId),
        ];

        return $data;
    }

    public function store(FormRequest $request): JsonResponse
    {
        $model = File::create($request->all());

        return response()->json([
            'error' => $model ? false : true,
            'model' => $model->load('children'),
        ], 200);
    }

    protected function move($ids, Request $request): JsonResponse
    {
        $data = $request->all();
        $number = 0;
        foreach (explode(',', $ids) as $id) {
            $model = File::find($id);
            foreach ($data as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
            $number += 1;
        }

        return response()->json(compact('number'));
    }

    public function destroy(File $file): JsonResponse
    {
        $deleted = $file->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    private function getPath($folderId): array
    {
        $folder = File::find($folderId);
        $path = [];
        while ($folder) {
            $path[] = $folder;
            $folder = $folder->folder;
        }

        $firstItem = new stdClass();
        $firstItem->name = __('Files');
        $firstItem->type = 'f';
        $firstItem->id = '';

        $path[] = $firstItem;
        $path = array_reverse($path);

        return $path;
    }

    public function sort(Request $request): void
    {
        foreach ($request->all() as $position => $item) {
            DB::table('model_has_files')
                ->where('file_id', $item['id'])
                ->update(['position' => $position + 1]);
        }
        cache()->flush();
    }
}
