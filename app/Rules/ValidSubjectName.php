<?php

namespace App\Rules;

use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;

class ValidSubjectName implements Rule
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

      if (empty($value) && empty($this->request->subject_id) && $this->request->type_subject == 'extracurricular') {
        $this->message = 'this '. $attribute .' is required';
        return false;

      }

      return true;
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
