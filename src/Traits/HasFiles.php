<?php

namespace TypiCMS\Modules\Files\Traits;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Files\Models\File;

trait HasFiles
{
    public static function bootHasFiles()
    {
        static::saved(function (Model $model) {
            if (request()->has('file_ids')) {
                $model->files()->detach();
                foreach (request()->input('file_ids') as $collectionName => $ids) {
                    $model->syncIds($ids, $collectionName);
                }
            }
        });
    }

    public function syncIds(?string $ids, string $collectionName): void
    {
        $idsArray = $ids !== null ? explode(',', $ids) : [];
        $data = [];
        $position = 1;
        foreach ($idsArray as $id) {
            $this->files()->attach($id, ['position' => $position++, 'collection_name' => $collectionName]);
        }
    }

    public function images()
    {
        return $this->files()->where('type', 'i');
    }

    public function documents()
    {
        return $this->files()->where('type', 'd');
    }

    public function videos()
    {
        return $this->files()->where('type', 'v');
    }

    public function audios()
    {
        return $this->files()->where('type', 'a');
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files', 'model_id', 'file_id')
            ->orderBy('model_has_files.collection_name')
            ->orderBy('model_has_files.position');
    }

    public function filesFromCollection(string $collectionName)
    {
        return $this->files()
            ->where('model_has_files.collection_name', $collectionName)
            ->get();
    }

    public function documentsFromCollection(string $collectionName)
    {
        return $this->documents()
            ->where('model_has_files.collection_name', $collectionName)
            ->get();
    }

    public function imagesFromCollection(string $collectionName)
    {
        return $this->images()
            ->where('model_has_files.collection_name', $collectionName)
            ->get();
    }
}
