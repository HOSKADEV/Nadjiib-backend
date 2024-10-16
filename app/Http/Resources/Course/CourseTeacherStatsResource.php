<?php

namespace App\Http\Resources\Course;

use App\Models\PurchaseCoupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseTeacherStatsResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    $user = $request->user;
    $teacher = $this->teacher;
    $total_purchases = $this->purchases()->where('status', 'success')->count();
    $invited_purchases = PurchaseCoupon::whereIn('purchase_id', $this->purchases()->where('purchases.status', 'success')->select('purchases.id')->get()->pluck('id')->toArray())
      ->where('coupon_id', $teacher->coupon_id)->count();
    $normal_purchases = $total_purchases - $invited_purchases;

    $bonuses = $this->bonuses()->select(DB::raw('MIN(type) AS type'), DB::raw('SUM(amount) AS amount'))
      ->groupBy(DB::raw('type > 1'))->get();


    $standard_amount = $bonuses->where('type', 1)->first()?->amount ?? 0;

    $bonuses_amount = $bonuses->where('type', 2)->first()?->amount ?? 0;

    $total_amount = $standard_amount + $bonuses_amount;

    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'price' => $this->price,
      'image' => is_null($this->image) ? null : url($this->image),
      'teacher_name' => $this->teacher->user->name,
      'lessons' => $this->lessons()->count(),
      'videos' => $this->videos()->count(),
      'files' => $this->files()->count(),
      //'is_wished' => empty($user) ? false : $user->student?->wished($this),
      //'is_purchased' => empty($user) ? false : $user->student?->purchased($this),
      //'is_owned' => empty($user) ? false : $user->student?->owns($this),
      'total_purchases' => $total_purchases,
      'invited_purchases' => $invited_purchases,
      'normal_purchases' => $normal_purchases,
      'standard_amount' => $standard_amount,
      'bonuses_amount' => $bonuses_amount,
      'total_amount' => $total_amount,
    ];

  }
}
