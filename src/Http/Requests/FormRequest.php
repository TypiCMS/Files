<?php
namespace TypiCMS\Modules\Files\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'file' => 'mimes:jpeg,gif,png,pdf,rtf,txt,md,doc,xls,ppt,docx,xlsx,ppsx,pptx,sldx|max:2000',
        ];
        return $rules;
    }
}
