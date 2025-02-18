<?php

namespace App\Rules;

use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;

class ValidCoupon implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */

  private $request;
  private $message;

  public function __construct($request)
  {
    $this->request = $request;
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    try{


      $coupon = Coupon::withTrashed()->where('code', $value)->first();

      if($coupon->deleted_at){
        $this->message = 'this '. $attribute .' is no longer valid';
        return false;
      }

      if ($attribute == 'invitation_code') {

        if ($coupon->type != 'invitation') {
          $this->message = 'this '. $attribute .' is not an invitation code';
          return false;
        }
        $course = Course::findOrFail($this->request->course_id);
        if ($coupon->id != $course->teacher->coupon_id) {
          $this->message = 'this '. $attribute .' does not belong to the course teacher';
          return false;
        }

      }

      if ($attribute == 'coupon_code') {

        if ($coupon->type != 'limited') {
          $this->message = 'this '. $attribute .' is not a limited code';
          return false;
        }

        if(!Carbon::now()->between($coupon->start_date, $coupon->end_date)){
          $this->message = 'this '. $attribute .' has expired';
          return false;
        }

        /* if($coupon->usages()->count() >= $coupon->max){
          $this->message = 'this '. $attribute .' has reached its maximum limit';
          return false;
        } */

      }

      return true;

    }catch (\Exception $e){
      $this->message = $e->getMessage();
      return false;
    }

  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return $this->message;
  }
}
