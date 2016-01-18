<?php

namespace TypiCMS\Modules\Files\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        $rules = [
            '*.alt_attribute' => 'max:255',
        ];
        if ($this->hasFile('file')) {
            $rules['file'] = 'mimes:jpeg,gif,png,bmp,tiff,pdf,eps,rtf,txt,md,doc,xls,ppt,docx,xlsx,ppsx,pptx,sldx|max:2000';
        }

        return $rules;
    }
}
