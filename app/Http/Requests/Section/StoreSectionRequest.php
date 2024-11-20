<?php

namespace App\Http\Requests\Section;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_ar'  =>'required|string|min:10|max:100|unique:sections,name_ar',
            'name_en'  =>'required|string|min:10|max:100|unique:sections,name_en',
            'name_fr'  =>'required|string|min:10|max:100|unique:sections,name_fr',
        ];
    }
    public function attributes() {
        return [
            'name_ar' => trans('section.name_ar'),
            'name_en' => trans('section.name_en'),
            'name_fr' => trans('section.name_fr'),
        ];
    }
}
