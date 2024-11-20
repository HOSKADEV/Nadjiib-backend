<?php

namespace App\Http\Resources\Call;

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
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
          'student_id' => $this->student_id,
          'teacher_id' => $this->teacher_id,
          'start_time' => $this->start_time,
          'end_time' => $this->end_time,
          'duration' => $this->duration(),
          'rating' => $this->rating,
        ];
    }
}
