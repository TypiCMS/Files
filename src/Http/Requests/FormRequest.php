<?php
namespace TypiCMS\Modules\Files\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'file' => 'mimes:jpeg,gif,png,pdf,rtf,txt,md,doc,xls,ppt,docx,xlsx,ppsx,pptx,sldx|max:2000',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.alt_attribute'] = 'max:255';
        }
        return $rules;
    }
}
