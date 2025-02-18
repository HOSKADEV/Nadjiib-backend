<?php

namespace App\Http\Requests\Level;

use Illuminate\Foundation\Http\FormRequest;

class StoreLevelRequest extends FormRequest
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
            'name_ar'  =>'required|string|min:10|max:100|unique:levels,name_ar',
            'name_en'  =>'required|string|min:10|max:100|unique:levels,name_en',
            'name_fr'  =>'required|string|min:10|max:100|unique:levels,name_fr',
            'specialty_ar'  =>'required|string|min:10|max:100|unique:levels,specialty_ar',
            'specialty_en'  =>'required|string|min:10|max:100|unique:levels,specialty_en',
            'specialty_fr'  =>'required|string|min:10|max:100|unique:levels,specialty_fr',
        ];
    }
    public function attributes() {
        return [
            'name_ar' => trans('level.name_ar'),
            'name_en' => trans('level.name_en'),
            'name_fr' => trans('level.name_fr'),
            'specialty_ar' => trans('level.specialty.name_ar'),
            'specialty_en' => trans('level.specialty.name_en'),
            'specialty_fr' => trans('level.specialty.name_fr'),
        ];
    }
}
