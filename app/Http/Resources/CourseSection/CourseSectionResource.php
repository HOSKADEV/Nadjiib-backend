<?php

namespace App\Http\Resources\CourseSection;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseSectionResource extends JsonResource
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
        'section_id'    => $this->section_id,
        'created_at'  => $this->created_at->format('d-m-Y'),
      ];
    }
}
