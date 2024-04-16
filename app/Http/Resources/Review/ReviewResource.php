<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
          'id'          => $this->id,
          'course_id'   => $this->course_id,
          'student_id'  => $this->student_id,
          'rating'      => $this->rating,
          'comment'     => $this->comment,
          'created'     => $this->created_at->format('d-m-Y'),
        ];
    }
}
