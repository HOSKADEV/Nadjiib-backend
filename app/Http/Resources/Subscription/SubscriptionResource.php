<?php

namespace App\Http\Resources\Subscription;

use Illuminate\Support\Carbon;
use App\Http\Resources\Subject\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
          'subject' => new SubjectResource($this->subject),
          'start_date' => $this->start_date,
          'end_date' => $this->end_date,
          'status' => Carbon::now()->isBetween($this->start_date,$this->end_date),
          'remaining' => Carbon::now()->diffInDays($this->end_date)
        ];
    }
}
