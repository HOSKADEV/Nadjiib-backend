<?php

namespace App\Http\Resources\CourseLevel;

use App\Http\Resources\Levels\LevelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseLevelResource extends JsonResource
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
          'level_id'    => $this->level_id,
          'created_at'  => $this->created_at->format('d-m-Y'),
        ];
    }
}
