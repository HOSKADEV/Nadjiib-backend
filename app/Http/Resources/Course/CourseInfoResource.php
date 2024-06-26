<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseInfoResource extends JsonResource
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
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'price' => $this->price,
      'image' => is_null($this->image) ? null : url($this->image),
      'teacher_name' => $this->teacher->user->name,
      'vidoes'      => $this->videos()->count(),
      'lessons'     => $this->lessons()->count(),
      'is_wished'   => empty($user) ? false : in_array($this->id, $user->student?->wishlists()->pluck('course_id')->toArray()),
    ];
  }
}
