<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use stdClass;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Repositories\EloquentFile;

class ApiController extends BaseApiController
{
    public function __construct(EloquentFile $file)
    {
        parent::__construct($file);
    }

    public function index(Request $request)
    {
        $folderId = request('folder_id');
        $view = request('view', 'index');

        $data = [
            'models' => $this->repository->with('children')->where('folder_id', $folderId)->findAll(),
            'path' => $this->getpath($folderId),
        ];

        return $data;
    }

    protected function update(File $file, Request $request)
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

        foreach ($data as $key => $value) {
            $file->$key = $value;
        }
        $saved = $file->save();

        $this->repository->forgetCache();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(File $file)
    {
        $deleted = $this->repository->delete($file);

        return response()->json([
            'error' => !$deleted,
        ]);
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
        $firstItem->name = __('Files');
        $firstItem->type = 'f';
        $firstItem->id = '';

        $path[] = $firstItem;
        $path = array_reverse($path);

        return $path;
    }

    /**
     * Sort files.
     */
    public function sort(Request $request)
    {
        foreach ($request->all() as $position => $item) {
            app('db')
                ->table('model_has_files')
                ->where('file_id', $item['id'])
                ->update(['position' => $position + 1]);
        }
        cache()->flush();
    }
}
