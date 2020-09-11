<?php

namespace TypiCMS\Modules\Files\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            'folder_id' => 'nullable|integer',
            'alt_attribute.*' => 'max:255',
            'description.*' => 'max:255',
            'name' => 'mimes:jpeg,gif,png,bmp,tiff,pdf,eps,rtf,txt,md,doc,xls,ppt,docx,xlsx,ppsx,pptx,sldx|max:'.config('typicms.max_file_upload_size', 2000),
        ];

        return $rules;
    }
}
