<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;

class ApiController extends BaseApiController
{
    public function index(Request $request): array
    {
        $folderId = $request->folder_id;

        $data = [
            'models' => File::with('children')->where('folder_id', $folderId)->get(),
            'path' => $this->getPath($folderId),
        ];

        return $data;
    }

    public function store(FormRequest $request): JsonResponse
    {
        $model = File::create($request->validated());

        return response()->json(compact('model'));
    }

    protected function move($ids, Request $request): JsonResponse
    {
        $idsArray = explode(',', $ids);
        foreach ($idsArray as $id) {
            File::where('id', $id)->update(['folder_id' => $request->folder_id]);
        }

        return response()->json(['number' => count($idsArray)]);
    }

    public function destroy(File $file)
    {
        $file->delete();
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
        $firstItem->name = __('Files', [], config('typicms.admin_locale'));
        $firstItem->type = 'f';
        $firstItem->id = '';

        $path[] = $firstItem;
        $path = array_reverse($path);

        return $path;
    }
}
