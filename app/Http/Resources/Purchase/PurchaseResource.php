<?php

namespace App\Http\Resources\Purchase;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PurchaseBonus\PurchaseBonusCollection;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'student_name' => $this->student->user->name,
          'course_name' => $this->course->name,
          'bonuses_total' => $this->bonuses()->sum('amount'),
          'bonuses' => new PurchaseBonusCollection($this->bonuses)
        ];
    }
}
