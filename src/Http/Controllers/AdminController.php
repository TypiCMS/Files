<?php

namespace TypiCMS\Modules\Files\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Files\Http\Requests\FormRequest;
use TypiCMS\Modules\Files\Models\File;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('files::admin.index');
    }

    public function edit(File $file): View
    {
        return view('files::admin.edit')->with(['model' => $file]);
    }

    public function update(File $file, FormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $file->update($data);

        return $this->redirect($request, $file);
    }
}
