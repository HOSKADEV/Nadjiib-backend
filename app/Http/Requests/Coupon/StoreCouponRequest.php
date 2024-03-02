<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'min:8',
                'max:8',
                'unique:coupons,code',
            ],
            'discount'  => [
                'required',
                'integer'
            ],
            'start_date'  => [
                'required',
                'date',
            ],
            'end_date'  => [
                'required',
                'date',
                'after:start_date',
            ]
        ];
    }

    public function attributes() {
        return [
            'code'       => trans('coupon.code'),
            'discount'   => trans('coupon.discount'),
            'start_date' => trans('coupon.start_date'),
            'end_date'   => trans('coupon.end_date'),
        ];
    }

    public function filters(){
        return [
            'code' => 'trim',
        ];
    }
    
}
