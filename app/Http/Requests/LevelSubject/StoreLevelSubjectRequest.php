<?php

namespace App\Http\Requests\LevelSubject;

use Illuminate\Foundation\Http\FormRequest;

class StoreLevelSubjectRequest extends FormRequest
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
            'list_level_subjects.*.level'   => 'required',
            'list_level_subjects.*.subject' => 'required',
        ];
    }
    public function attributes() {
        return [
            'level'   => trans('levelsubject.level.name'),
            'subject' => trans('levelsubject.subject.name'),
        ];
    }


    // public function messages()
    // {
    //     return [
    //         'Name.required' => trans('validation.required'),
    //         'Name_class_en.required' => trans('validation.required'),
    //     ];
    // }
}
