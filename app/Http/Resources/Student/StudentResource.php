<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\Review\ReviewUserResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
          'student_id' => $this->id,
          //'user' => new ReviewUserResource($this->user),
          'level_id' => $this->level_id,
        ];
    }
}
