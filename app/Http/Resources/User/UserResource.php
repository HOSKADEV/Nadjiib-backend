<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Teacher\TeacherResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
      "user_id" => $this->id,
      "student" => new StudentResource($this->student),
      'teacher' => new TeacherResource($this->teacher),
      "name" => $this->name,
      "email" => $this->email,
      "phone" => $this->phone,
      "gender" => $this->gender,
      "image" => $this->image,
      "role" => $this->role,
    ];
  }
}
