<?php
namespace TypiCMS\Modules\Files\Http\Controllers;

use Input;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Repositories\FileInterface as Repository;
use Response;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get models
     * @return Response
     */
    public function index()
    {
        $gallery_id = Input::get('gallery_id');
        $type = Input::get('type');
        $page = Input::get('page');
        $perPage = config('typicms.files.per_page');
        if ($gallery_id = Input::get('gallery_id', 0)) {
            $models = $this->repository->allBy('gallery_id', $gallery_id, [], true);
        } else {
            $models = $this->repository->byPageFrom($page, $perPage, $gallery_id, [], true, $type);
            $models = $models->items;
        }
        return Response::json($models, 200);
    }
}
